<?php

use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\EncryptedPrivateChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Meetjet\LaravelCentrifugo\Traits\UseCentrifugoChannelConventions;

it('is private channel', function () {
    $broadcaster = new FakeBroadcasterUsingPusherChannelsNames;
    $channelName = 'private-channel';
    $this->assertTrue($broadcaster->isPrivateChannel($channelName));
});

it('is not private channel', function () {
    $broadcaster = new FakeBroadcasterUsingPusherChannelsNames;
    $channelName = 'public-channel';
    $this->assertFalse($broadcaster->isPrivateChannel($channelName));
});

it('is normalized channels names correct', function () {
    $broadcaster = new FakeBroadcasterUsingPusherChannelsNames;
    $channelsList = [
        new Channel('channel'),
        new PrivateChannel('channel'),
        new EncryptedPrivateChannel('channel'),
    ];
    $channelsNamesNormalizedList = [
        'channel',
        '$channel',
        '$channel',
    ];
    $this->assertEquals($broadcaster->normalizeChannelsNames($channelsList), $channelsNamesNormalizedList);
});

class FakeBroadcasterUsingPusherChannelsNames extends Broadcaster
{
    use UseCentrifugoChannelConventions;

    public function auth($request)
    {
        //
    }

    public function validAuthenticationResponse($request, $result)
    {
        //
    }

    public function broadcast(array $channels, $event, array $payload = [])
    {
        //
    }
}
