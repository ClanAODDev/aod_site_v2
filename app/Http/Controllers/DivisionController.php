<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DivisionDetails;
use Inertia\Inertia;
use Inertia\Response;

class DivisionController extends Controller
{
    public function __construct(
        private readonly DivisionDetails $details,
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
        $data = $this->details->findOrAbort($division);

        return Inertia::render('division/show', [
            'division' => [
                'name' => $data['name'],
                'icon' => $data['icon'],
                'headerImage' => DivisionDetails::headerImage($data['abbreviation']),
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
