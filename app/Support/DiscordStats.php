<?php

declare(strict_types=1);

namespace App\Support;

use App\Repositories\AOD\SocialRepository;

class DiscordStats
{
    public function __construct(
        private readonly SocialRepository $social,
    ) {}

    public function get(): ?array
    {
        if (app()->environment('local')) {
            return json_decode(file_get_contents(storage_path('testing/discord.json')), true)['data'];
        }

        return TrackerCache::remember('aod_discord', function () {
            $raw = $this->social->getDiscord()->throw()->json('data');

            return is_array($raw) ? $raw : null;
        });
    }
}
