<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\SocialRepository;
use App\Repositories\AOD\TwitchRepository;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly SocialRepository $social,
        private readonly TwitchRepository $twitch,
    ) {}

    public function __invoke(): View
    {
        if (app()->environment('local')) {
            $discord = json_decode(file_get_contents(storage_path('testing/discord.json')), true)['data'];
        } else {
            $discord = cache()->remember('aod_discord', config('app.cache_length'), function () {
                $raw = $this->social->getDiscord()->json('data');

                return is_array($raw) ? $raw : null;
            });
        }

        $twitch = $this->getTwitchData();
        $highlightedEvent = $this->getActiveHighlightedEvent();

        $showTwitchLive = $twitch['is_live'] ?? false;
        $showHighlightedEvent = ! $showTwitchLive && $highlightedEvent !== null;
        $showVods = ! $showTwitchLive && ! $showHighlightedEvent && ! empty($twitch['vods']);
        $isChristmas = $highlightedEvent !== null && ($highlightedEvent['theme'] ?? '') === 'holiday';

        return view('pages.home', [
            'discord' => $discord,
            'twitch' => $twitch,
            'highlightedEvent' => $highlightedEvent,
            'showTwitchLive' => $showTwitchLive,
            'showHighlightedEvent' => $showHighlightedEvent,
            'showVods' => $showVods,
            'isChristmas' => $isChristmas,
        ]);
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
}
