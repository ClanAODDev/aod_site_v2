<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\SocialRepository;
use App\Repositories\AOD\TwitchRepository;
use App\Support\TrackerCache;
use Carbon\CarbonImmutable;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        private readonly SocialRepository $social,
        private readonly TwitchRepository $twitch,
    ) {}

    public function __invoke(): Response
    {
        $discord = $this->getDiscordData();
        $twitch = $this->getTwitchData();
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

    private function getDiscordData(): ?array
    {
        if (app()->environment('local')) {
            return json_decode(file_get_contents(storage_path('testing/discord.json')), true)['data'];
        }

        return TrackerCache::remember('aod_discord', function () {
            $raw = $this->social->getDiscord()->throw()->json('data');

            return is_array($raw) ? $raw : null;
        });
    }

    private function getTwitchData(): array
    {
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
