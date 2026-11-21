<?php

declare(strict_types=1);

namespace App\Support;

use App\Repositories\AOD\TwitchRepository;

class TwitchStream
{
    public function __construct(
        private readonly TwitchRepository $twitch,
    ) {}

    public function get(): array
    {
        if (app()->environment('local') && request()->has('live')) {
            $live = json_decode(file_get_contents(storage_path('testing/twitch_live.json')), true);
            $channel = (string) request()->query('live');

            if (preg_match('/^[A-Za-z0-9_]{3,25}$/', $channel) === 1 && $channel !== '1') {
                $live['channel'] = $channel;
            }

            return $live;
        }

        if (config('services.twitch.client_id') && config('services.twitch.client_secret')) {
            return $this->twitch->getStreamData();
        }

        if (app()->environment('local')) {
            return json_decode(file_get_contents(storage_path('testing/twitch.json')), true);
        }

        return [
            'is_live' => false,
            'stream' => null,
            'vods' => [],
            'channel' => config('services.twitch.channel', 'clanaodstream'),
        ];
    }
}
