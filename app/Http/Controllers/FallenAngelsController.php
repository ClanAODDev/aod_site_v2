<?php

namespace App\Http\Controllers;

class FallenAngelsController extends Controller
{
    public function __invoke()
    {
        $fallen = config('aod.fallen-angels');

        return view('pages.fallen-angels', compact('fallen'));
    }
}
