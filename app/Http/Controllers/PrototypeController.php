<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DiscordStats;
use App\Support\TwitchStream;
use Inertia\Inertia;
use Inertia\Response;

class PrototypeController extends Controller
{
    public function __invoke(DiscordStats $discord, TwitchStream $twitch): Response
    {
        return Inertia::render('next/home', [
            'discord' => $discord->get(),
            'twitch' => $twitch->get(),
            'foundedYear' => 1999,
            'currentYear' => (int) now()->year,
        ])->withViewData([
            'metaTitle' => 'Angels of Death | Prototype',
            'metaDescription' => 'A prototype of the next ClanAOD.net.',
        ]);
    }
}
