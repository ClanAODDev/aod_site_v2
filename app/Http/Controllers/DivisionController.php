<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\AOD\DivisionRepository;
use App\Support\TrackerCache;
use App\Support\TrackerDivisions;
use GrahamCampbell\Markdown\Facades\Markdown;
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
        if (TrackerDivisions::hasSlug($division) === false) {
            abort(404, 'Bad division request');
        }

        $result = TrackerCache::remember(
            'aod_division_' . strtolower($division),
            fn () => $this->fetchDivision($division)
        );

        if ($result === null) {
            abort(503);
        }

        if (! $result['found']) {
            abort(404, 'Bad division request');
        }

        $data = $result['division'];

        return Inertia::render('division/show', [
            'division' => [
                'name' => $data['name'],
                'icon' => $data['icon'],
                'headerImage' => $this->headerImage($data['abbreviation']),
                'siteContentHtml' => $data['siteContentHtml'],
                'screenshots' => $data['screenshots'],
            ],
        ])->withViewData([
            'metaTitle' => "{$data['name']} Division | Angels of Death",
            'metaDescription' => $data['metaDescription'],
            'metaImage' => $data['icon'],
            'structuredData' => $this->breadcrumbStructuredData($data['name']),
        ]);
    }

    private function fetchDivision(string $slug): array
    {
        $response = $this->divisions->find($slug);

        if ($response->notFound()) {
            return ['found' => false];
        }

        $data = $response->throw()->json('data.division');

        if (! $data) {
            return ['found' => false];
        }

        return [
            'found' => true,
            'division' => [
                'name' => $data['name'],
                'abbreviation' => $data['abbreviation'],
                'icon' => $data['icon'] ?? null,
                'metaDescription' => $data['settings']['meta_description'] ?? null,
                'siteContentHtml' => ! empty($data['site_content']) ? (string) Markdown::convertToHtml($data['site_content']) : null,
                'screenshots' => array_values(array_map(
                    fn (array $screenshot) => [
                        'url' => $screenshot['url'] ?? null,
                        'caption' => $screenshot['caption'] ?? null,
                    ],
                    $data['screenshots'] ?? []
                )),
            ],
        ];
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
