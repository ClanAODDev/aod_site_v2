<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Facades\App\Repositories\AOD\DivisionRepository;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $divisions = [];

        try {
            $divisions = DivisionRepository::all()->json('data') ?? [];
        } catch (\Exception) {}

        return response()
            ->view('sitemap', compact('divisions'))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
