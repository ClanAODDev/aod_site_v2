<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DiscordStats;
use App\Support\Season;
use App\Support\TwitchStream;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    private const MERCH_COUNT = 8;

    public function __invoke(DiscordStats $discord, TwitchStream $twitch, Season $season): Response
    {
        return Inertia::render('next/home', [
            'discord' => $discord->get(),
            'twitch' => $twitch->get(),
            'season' => $season->current(),
            'heroVideoId' => config('aod.hero_video_id'),
            'introVideoId' => config('aod.intro_video_id'),
            'historyVideoId' => config('aod.modern_era_video_id'),
            'merch' => $this->merch(),
        ])->withViewData([
            'metaTitle' => 'Angels of Death Gaming Clan | Since 1999',
            'metaDescription' => 'Angels of Death is a multi-game gaming community founded in 1999 with 1,200+ active members across 10 active divisions worldwide. Join us on PC, PlayStation, and Xbox.',
            'structuredData' => $this->structuredData(),
        ]);
    }

    private function merch(): array
    {
        $merch = config('aod.merch');

        return [
            'storeUrl' => $merch['store_url'],
            'items' => collect($merch['items'])->shuffle()->take(self::MERCH_COUNT)->map(fn (array $item) => [
                'name' => $item['name'],
                'href' => "{$merch['store_url']}/{$item['slug']}",
                'image' => "{$merch['image_base_url']}{$item['image_id']}{$merch['image_suffix']}",
            ])->values()->all(),
        ];
    }

    private function structuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    'name' => 'Angels of Death',
                    'alternateName' => 'ClanAOD',
                    'url' => url('/'),
                    'logo' => asset('images/official-logo.png'),
                    'foundingDate' => '1999',
                    'description' => 'Angels of Death is a mature multi-game gaming community founded in 1999, with 10 active game divisions and 1,200+ members worldwide.',
                    'sameAs' => [
                        'https://discord.gg/clanaod',
                        'https://www.twitch.tv/clanaodstream',
                        'https://twitter.com/officialclanaod',
                        'https://steamcommunity.com/groups/clanaod',
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    'name' => 'ClanAOD.net',
                    'url' => url('/'),
                ],
            ],
        ];
    }
}
