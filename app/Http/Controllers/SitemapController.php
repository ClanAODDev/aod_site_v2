<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\DivisionRepository;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(
        private readonly DivisionRepository $divisions,
    ) {}

    public function __invoke(): Response
    {
        $divisions = [];

        try {
            $divisions = $this->divisions->all()->json('data') ?? [];
        } catch (\Exception) {
        }

        return response()
            ->view('sitemap', compact('divisions'))
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }
}
