<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class HistoryController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('history', [
            'foundationsEraVideoId' => config('aod.foundations_era_video_id'),
            'modernEraVideoId' => config('aod.modern_era_video_id'),
        ])->withViewData([
            'metaTitle' => 'History of AOD | Angels of Death',
            'metaDescription' => 'Explore the history of the Angels of Death gaming clan — from its founding in 1999 through 25+ years of growth, leadership, and community across over 56 major gaming titles.',
        ]);
    }
}
