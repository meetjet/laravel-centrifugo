<?php

declare(strict_types=1);

namespace Meetjet\LaravelCentrifugo;

use Exception;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Broadcasting\BroadcastException;
use Illuminate\Http\Request;
use Meetjet\LaravelCentrifugo\Traits\UseCentrifugoChannelConventions;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LaravelCentrifugoBroadcaster extends Broadcaster
{

    use UseCentrifugoChannelConventions;

    /**
     * The Centrifugo SDK instance.
     *
     * @var Contracts\LaravelCentrifugoInterface
     */
    protected $centrifugo;

    /**
     * Create a new broadcaster instance.
     *
     * @param LaravelCentrifugo $centrifugo
     */
    public function __construct(LaravelCentrifugo $centrifugo)
    {
        $this->centrifugo = $centrifugo;
    }

    /**
     * Authenticate the incoming request for a given channel.
     *
     * @param Request $request
     * @return mixed
     */
    public function auth($request)
    {
        if ($request->user()) {
            $client = $this->getClientFromRequest($request);
            $channels = $this->getChannelsFromRequest($request);

            $response = [];
            $privateResponse = [];
            foreach ($channels as $channel) {
                $channelName = $this->getChannelName($channel);

                try {
                    $is_access_granted = $this->verifyUserCanAccessChannel($request, $channelName);
                } catch (HttpException $e) {
                    $is_access_granted = false;
                }

                if ($private = $this->isPrivateChannel($channel)) {
                    $privateResponse['channels'][] = $this->makeResponseForPrivateClient($is_access_granted, $channel, $client);
                } else {
                    $response[$channel] = $this->makeResponseForClient($is_access_granted, $client);
                }
            }

            return response($private ? $privateResponse : $response);
        } else {
            throw new HttpException(401);
        }
    }

    /**
     * Return the valid authentication response.
     *
     * @param Request $request
     * @param mixed $result
     * @return mixed
     */
    public function validAuthenticationResponse($request, $result)
    {
        return $result;
    }

    /**
     * Broadcast the given event.
     *
     * @param array $channels
     * @param string $event
     * @param array $payload
     * @return void
     */
    public function broadcast(array $channels, $event, array $payload = [])
    {
        $payload['event'] = $event;

        $response = $this->centrifugo->broadcast($this->normalizeChannelsNames($channels), $payload);

        if (is_array($response) && ! isset($response['error'])) {
            return;
        }

        throw new BroadcastException(
            $response['error'] instanceof Exception ? $response['error']->getMessage() : $response['error']
        );
    }

    /**
     * Get client from request.
     *
     * @param Request $request
     * @return string
     */
    private function getClientFromRequest(Request $request): string
    {
        return $request->get('client', '');
    }

    /**
     * Get channels from request.
     *
     * @param Request $request
     * @return array
     */
    private function getChannelsFromRequest(Request $request): array
    {
        $channels = $request->get('channels', []);

        return is_array($channels) ? $channels : [$channels];
    }

    /**
     * Get channel name without $ symbol (if present).
     *
     * @param string $channel
     * @return string
     */
    private function getChannelName(string $channel): string
    {
        return $this->isPrivateChannel($channel) ? substr($channel, 1) : $channel;
    }

    /**
     * Make response for client, based on access rights.
     *
     * @param bool $access_granted
     * @param string $client
     * @return array
     */
    private function makeResponseForClient(bool $access_granted, string $client): array
    {
        $info = [];

        return $access_granted ? [
            'sign' => $this->centrifugo->generateConnectionToken($client, 0, $info),
            'info' => $info,
        ] : [
            'status' => 403,
        ];
    }

    /**
     * Make response for client, based on access rights of private channel.
     *
     * @param bool $access_granted
     * @param string $channel
     * @param string $client
     * @return array
     */
    private function makeResponseForPrivateClient(bool $access_granted, string $channel, string $client): array
    {
        $info = [];

        return $access_granted ? [

            'channel' => $channel,
            'token' => $this->centrifugo->generatePrivateChannelToken($client, $channel, 0, $info),
            'info' => $this->centrifugo->info(),

        ] : [
            'status' => 403,
        ];
    }
}
