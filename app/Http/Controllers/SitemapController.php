<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\TrackerDivisions;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $divisions = TrackerDivisions::all();

        return response()
            ->view('sitemap', compact('divisions'))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
