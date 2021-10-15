<?php

namespace Meetjet\LaravelCentrifugo\Traits;

use Illuminate\Support\Str;

trait UseCentrifugoChannelConventions
{
    /**
     * Return true if the channel is private.
     *
     * @param string $channel
     * @return bool
     */
    public function isPrivateChannel(string $channel): bool
    {
        return Str::startsWith($channel, ['private-encrypted-', 'private-']);
    }

    /**
     * Format channels to string and change prefix for private channels names.
     *
     * @param array $channels
     * @return array
     */
    public function normalizeChannelsNames(array $channels): array
    {
        return array_map(function ($channel) {
            $channel = (string) $channel;
            foreach (['private-encrypted-', 'private-'] as $prefix) {
                if (Str::startsWith($channel, $prefix)) {
                    return Str::replaceFirst($prefix, '$', $channel);
                }
            }
            return $channel;
        }, $channels);
    }
}
