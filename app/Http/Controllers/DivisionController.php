<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\DivisionRepository;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Client\ConnectionException;
use Inertia\Inertia;
use Inertia\Response;

class DivisionController extends Controller
{
    public function __construct(
        private readonly DivisionRepository $divisions,
    ) {}

    public function index(): Response
    {
        return Inertia::render('division/index')->withViewData([
            'metaTitle' => 'Gaming Divisions | Angels of Death',
            'metaDescription' => 'Our gaming divisions are the lifeblood of the Angels of Death community. A great deal of effort goes into vetting each division request to ensure the game is a good fit and the new division will have the right leadership to support its progress.',
        ]);
    }

    public function show(string $division): Response
    {
        try {
            $response = $this->divisions->find($division);
        } catch (ConnectionException) {
            abort(503);
        }

        if ($response->failed() && ! $response->notFound()) {
            abort(503);
        }

        $data = $response->json('data.division');

        if (! $data) {
            abort(404, 'Bad division request');
        }

        return Inertia::render('division/show', [
            'division' => [
                ...$data,
                'headerImage' => $this->headerImage($data['abbreviation']),
                'siteContentHtml' => ! empty($data['site_content']) ? (string) Markdown::convertToHtml($data['site_content']) : null,
            ],
        ])->withViewData([
            'metaTitle' => "{$data['name']} Division | Angels of Death",
            'metaDescription' => $data['settings']['meta_description'] ?? null,
            'metaImage' => $data['icon'] ?? null,
            'structuredData' => $this->breadcrumbStructuredData($data['name']),
        ]);
    }

    private function headerImage(string $abbreviation): string
    {
        $path = "images/division-headers/{$abbreviation}.jpg";

        return asset(file_exists(public_path($path)) ? $path : 'images/page-header.jpg');
    }

    private function breadcrumbStructuredData(string $divisionName): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Gaming Divisions', 'item' => route('division.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => "{$divisionName} Division", 'item' => url()->current()],
            ],
        ];
    }
}
