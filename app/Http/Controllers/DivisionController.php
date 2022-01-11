<?php

namespace App\Http\Controllers;

use App\Repositories\AOD\DivisionRepository;
use Illuminate\Contracts\View\View;

class DivisionController extends Controller
{
    public string $cacheKey = 'aod_content_';

    /**
     * Show all divisions
     */
    public function index(): View
    {
        return view('division.index');
    }

    /**
     * Show an individual division
     */
    public function show($division): View
    {
        if (!view()->exists("division.content.{$division}")) {
            abort(404, 'Division not found');
        }

        $response = (app()->environment('local'))
            ? $this->getDummyDivision()
            : (new DivisionRepository())->find($division)->json('data.division');

        if (empty($response)) {
            abort(404, 'Division request failed, malformed response');
        }

        cache()->remember(
            "{$this->cacheKey}{$division}",
            config('app.cache_length'),
            fn () => $response
        );

        return view('division.show', [
            'data' => cache()->get("{$this->cacheKey}{$division}"),
        ])->with('division');
    }

    private function getDummyDivision()
    {
        $data = json_decode(file_get_contents(storage_path('testing/division.json')), true);

        return $data['data']['division'];
    }
}
