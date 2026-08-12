<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\FallenMemberRepository;
use Illuminate\Contracts\View\View;

class FallenAngelsController extends Controller
{
    public function __construct(
        private readonly FallenMemberRepository $fallenMembers,
    ) {}

    public function __invoke(): View
    {
        $fallen = cache()->remember('aod_fallen_members', config('app.cache_length'), function () {
            try {
                return $this->fallenMembers->all()->json('data') ?? [];
            } catch (\Exception) {
                return [];
            }
        });

        return view('pages.fallen-angels', compact('fallen'));
    }
}
