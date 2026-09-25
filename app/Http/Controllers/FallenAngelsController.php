<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\FallenMemberRepository;
use App\Support\TrackerCache;
use Inertia\Inertia;
use Inertia\Response;

class FallenAngelsController extends Controller
{
    public function __construct(
        private readonly FallenMemberRepository $fallenMembers,
    ) {}

    public function __invoke(): Response
    {
        return Inertia::render('fallen-angels', [
            'fallen' => $this->fallen(),
        ])->withViewData([
            'metaTitle' => 'Fallen Angels | Angels of Death',
            'metaDescription' => 'The Clan AOD community has a storied history, and through the years some have been lost. This is our way of honoring their memory; May their souls rest in peace.',
        ]);
    }

    /**
     * The API may return this keyed by id rather than as a sequential list (as
     * tracker.clanaod.net/api/v1/divisions does) - re-index with array_values()
     * so it always serializes as a JSON array for the frontend.
     */
    private function fallen(): array
    {
        return TrackerCache::remember(
            'aod_fallen_members',
            fn () => array_values($this->fallenMembers->all()->throw()->json('data') ?? [])
        ) ?? [];
    }
}
