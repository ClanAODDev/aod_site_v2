<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class FallenAngelsController extends Controller
{
    public function __invoke(): View
    {
        $fallen = config('aod.fallen-angels', []);

        return view('pages.fallen-angels', compact('fallen'));
    }
}
