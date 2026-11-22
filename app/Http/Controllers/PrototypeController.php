<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\FallenMemberRepository;
use App\Support\DiscordStats;
use App\Support\DivisionDetails;
use App\Support\Season;
use App\Support\TrackerCache;
use App\Support\TwitchStream;
use Inertia\Inertia;
use Inertia\Response;

class PrototypeController extends Controller
{
    private const FOUNDED = 1999;

    public function home(DiscordStats $discord, TwitchStream $twitch, Season $season): Response
    {
        return Inertia::render('next/home', [
            'discord' => $discord->get(),
            'twitch' => $twitch->get(),
            'season' => $season->current(),
            'heroVideoId' => config('aod.hero_video_id'),
            'introVideoId' => config('aod.intro_video_id'),
            'historyVideoId' => config('aod.modern_era_video_id'),
            'foundedYear' => self::FOUNDED,
            'currentYear' => (int) now()->year,
        ])->withViewData([
            'metaTitle' => 'Angels of Death | Prototype',
            'metaDescription' => 'A prototype of the next ClanAOD.net.',
        ]);
    }

    public function fallenAngels(FallenMemberRepository $fallenMembers): Response
    {
        $fallen = TrackerCache::remember(
            'aod_fallen_members',
            fn () => array_values($fallenMembers->all()->throw()->json('data') ?? [])
        ) ?? [];

        return Inertia::render('next/fallen-angels', [
            'fallen' => $fallen,
            'foundedYear' => self::FOUNDED,
            'currentYear' => (int) now()->year,
        ])->withViewData([
            'metaTitle' => 'Fallen Angels | Prototype',
            'metaDescription' => 'A prototype of the next ClanAOD.net.',
        ]);
    }

    public function ranks(): Response
    {
        return $this->page('next/ranks', 'Ranking Structure');
    }

    public function codeOfConduct(): Response
    {
        return $this->page('next/code-of-conduct', 'Code of Conduct');
    }

    public function division(string $division, DivisionDetails $details): Response
    {
        $data = $details->findOrAbort($division);

        return Inertia::render('next/division', [
            'division' => [
                ...collect($data)->except('metaDescription')->all(),
                'backdrop' => $data['heroImage'] ?? ($data['screenshots'][0]['url'] ?? null),
            ],
            'foundedYear' => self::FOUNDED,
            'currentYear' => (int) now()->year,
        ])->withViewData([
            'metaTitle' => "{$data['name']} | Prototype",
            'metaDescription' => 'A prototype of the next ClanAOD.net.',
        ]);
    }

    private function page(string $component, string $title): Response
    {
        return Inertia::render($component, [
            'foundedYear' => self::FOUNDED,
            'currentYear' => (int) now()->year,
        ])->withViewData([
            'metaTitle' => "{$title} | Prototype",
            'metaDescription' => 'A prototype of the next ClanAOD.net.',
        ]);
    }
}
