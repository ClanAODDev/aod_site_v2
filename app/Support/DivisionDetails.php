<?php

declare(strict_types=1);

namespace App\Support;

use App\Repositories\AOD\DivisionRepository;
use GrahamCampbell\Markdown\Facades\Markdown;

class DivisionDetails
{
    public function __construct(
        private readonly DivisionRepository $divisions,
    ) {}

    public function findOrAbort(string $slug): array
    {
        abort_if(TrackerDivisions::hasSlug($slug) === false, 404, 'Bad division request');

        $result = $this->find($slug);

        abort_if($result === null, 503);
        abort_unless($result['found'], 404, 'Bad division request');

        return $result['division'];
    }

    public function find(string $slug): ?array
    {
        return TrackerCache::remember(
            'aod_division_details_' . strtolower($slug),
            fn () => $this->fetch($slug)
        );
    }

    private function fetch(string $slug): array
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
                'slug' => $data['slug'] ?? $slug,
                'abbreviation' => $data['abbreviation'],
                'icon' => $data['icon'] ?? null,
                'membersCount' => $data['members_count'] ?? null,
                'heroImage' => $data['hero_image'] ?? null,
                'metaDescription' => $data['settings']['meta_description'] ?? null,
                'siteContentHtml' => ! empty($data['site_content']) ? (string) Markdown::convertToHtml($data['site_content']) : null,
                'screenshots' => array_values(array_map(
                    fn (array $screenshot) => [
                        'url' => $screenshot['url'] ?? null,
                        'caption' => $screenshot['caption'] ?? null,
                    ],
                    $data['screenshots'] ?? []
                )),
                'leadership' => array_values(array_map(
                    fn (array $leader) => [
                        'name' => $leader['name'] ?? '',
                        'position' => $leader['position'] ?? null,
                        'rank' => $leader['rank']['label'] ?? null,
                        'rankColor' => $leader['rank']['color'] ?? null,
                    ],
                    $data['leadership'] ?? []
                )),
            ],
        ];
    }

    public static function headerImage(string $abbreviation): string
    {
        $path = "images/division-headers/{$abbreviation}.jpg";

        return asset(file_exists(public_path($path)) ? $path : 'images/page-header.jpg');
    }
}
