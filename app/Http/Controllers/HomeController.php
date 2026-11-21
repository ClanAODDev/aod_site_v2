<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DiscordStats;
use App\Support\TwitchStream;
use Carbon\CarbonImmutable;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        private readonly DiscordStats $discordStats,
        private readonly TwitchStream $twitchStream,
    ) {}

    public function __invoke(): Response
    {
        $discord = $this->discordStats->get();
        $twitch = $this->twitchStream->get();
        $highlightedEvent = $this->getActiveHighlightedEvent();

        $showTwitchLive = $twitch['is_live'] ?? false;
        $showHighlightedEvent = ! $showTwitchLive && $highlightedEvent !== null;
        $showVods = ! $showTwitchLive && ! $showHighlightedEvent && ! empty($twitch['vods']);

        $merch = config('aod.merch');
        $merch['items'] = collect($merch['items'])->shuffle()->values()->all();

        return Inertia::render('home', [
            'discord' => $discord,
            'twitch' => $twitch,
            'highlightedEvent' => $highlightedEvent,
            'showTwitchLive' => $showTwitchLive,
            'showHighlightedEvent' => $showHighlightedEvent,
            'showVods' => $showVods,
            'heroVideoId' => config('aod.hero_video_id'),
            'introVideoId' => config('aod.intro_video_id'),
            'merch' => $merch,
        ])->withViewData([
            'metaTitle' => 'Angels of Death Gaming Clan | Since 1999',
            'metaDescription' => 'Angels of Death is a multi-game gaming community founded in 1999 with 1,200+ active members across 10 active divisions worldwide. Join us on PC, PlayStation, and Xbox.',
            'structuredData' => $this->structuredData(),
        ]);
    }

    private function getActiveHighlightedEvent(): ?array
    {
        $events = config('aod.highlighted_events', []);
        $now = now();

        foreach ($events as $event) {
            if (! ($event['enabled'] ?? false)) {
                continue;
            }

            $startDate = CarbonImmutable::createFromFormat('m-d', $event['start_date'])->year($now->year);
            $endDate = CarbonImmutable::createFromFormat('m-d', $event['end_date'])->year($now->year);

            if ($endDate->lt($startDate)) {
                if ($now->month >= $startDate->month) {
                    $endDate = $endDate->addYear();
                } else {
                    $startDate = $startDate->subYear();
                }
            }

            if ($now->between($startDate, $endDate)) {
                return $event;
            }
        }

        return null;
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
