<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\SocialRepository;
use App\Repositories\AOD\TwitchRepository;
use Carbon\CarbonImmutable;

class HomeController extends Controller
{
    public function __invoke()
    {
        $this->getCommoStats(
            (app()->environment('local'))
                ? $this->getDummyData() : [
                    'aod_discord' => (new SocialRepository)->getDiscord()->json('data'),
                ]
        );

        $twitch = $this->getTwitchData();
        $highlightedEvent = $this->getActiveHighlightedEvent();

        $showTwitchLive = $twitch['is_live'] ?? false;
        $showHighlightedEvent = ! $showTwitchLive && $highlightedEvent !== null;
        $showVods = ! $showTwitchLive && ! $showHighlightedEvent && ! empty($twitch['vods']);
        $isChristmas = $highlightedEvent !== null && ($highlightedEvent['theme'] ?? '') === 'holiday';

        return view('pages.home', [
            'discord' => cache()->get('aod_discord'),
            'twitch' => $twitch,
            'highlightedEvent' => $highlightedEvent,
            'showTwitchLive' => $showTwitchLive,
            'showHighlightedEvent' => $showHighlightedEvent,
            'showVods' => $showVods,
            'isChristmas' => $isChristmas,
        ]);
    }

    private function getCommoStats($items)
    {
        foreach ($items as $cacheKey => $closure) {
            cache()->remember(
                $cacheKey,
                config('app.cache_length'),
                fn () => $closure
            );
        }
    }

    private function getDummyData(): array
    {
        $items = [
            'aod_discord' => 'discord.json',
        ];

        foreach ($items as $cacheKey => $file) {
            $items[$cacheKey] = json_decode(
                file_get_contents(storage_path("testing/{$file}")),
                true
            )['data'];
        }

        return $items;
    }

    private function getTwitchData(): array
    {
        if (config('services.twitch.client_id') && config('services.twitch.client_secret')) {
            return (new TwitchRepository)->getStreamData();
        }

        if (app()->environment('local')) {
            return json_decode(
                file_get_contents(storage_path('testing/twitch.json')),
                true
            );
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
}
