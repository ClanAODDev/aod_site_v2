<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\DivisionRepository;
use Illuminate\Contracts\View\View;

class DivisionController extends Controller
{
    public string $cacheKey = 'aod_content_';

    /**
     * Show all divisions.
     */
    public function index(): View
    {
        return view('division.index');
    }

    /**
     * Show an individual division.
     */
    public function show($division): View
    {
        $data = (new DivisionRepository)->find($division)->json('data');

        if (! $data) {
            abort(404, 'Bad division request');
        }

        return view('division.show', compact('data'))->with('division');
    }
}
