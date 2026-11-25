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

    public function show(string $division): Response
    {
        $data = $this->details->findOrAbort($division);

        return Inertia::render('next/division', [
            'division' => [
                ...collect($data)->except(['metaDescription', 'heroImagePosition'])->all(),
                'backdrop' => $data['heroImage'] ?? ($data['screenshots'][0]['url'] ?? null),
                'backdropPosition' => isset($data['heroImage']) ? ($data['heroImagePosition'] ?? null) : null,
            ],
        ])->withViewData([
            'metaTitle' => "{$data['name']} Division | Angels of Death",
            'metaDescription' => $data['metaDescription'] ?: $this->fallbackDescription($data),
            ...$this->previewImage($data),
            'structuredData' => $this->breadcrumbStructuredData($data['name']),
        ]);
    }

    private function previewImage(array $data): array
    {
        $wide = $data['heroImage'] ?? ($data['screenshots'][0]['url'] ?? null);

        return $wide
            ? ['metaImage' => $wide, 'metaCard' => 'summary_large_image']
            : ['metaImage' => $data['icon'], 'metaCard' => 'summary'];
    }

    private function fallbackDescription(array $data): string
    {
        $description = "Play {$data['name']} with the Angels of Death, a gaming community since 1999.";

        return $data['membersCount']
            ? $description . ' ' . number_format($data['membersCount']) . ' members and counting.'
            : $description;
    }

    private function breadcrumbStructuredData(string $divisionName): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Gaming Divisions', 'item' => route('home') . '#divisions'],
                ['@type' => 'ListItem', 'position' => 3, 'name' => "{$divisionName} Division", 'item' => url()->current()],
            ],
        ];
    }
}
