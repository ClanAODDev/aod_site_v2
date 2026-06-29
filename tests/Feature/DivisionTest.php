<?php

use Illuminate\Support\Facades\Http;

describe('Division Pages', function () {
    describe('Division Index', function () {
        it('loads successfully', function () {
            $this->get(route('division.index'))
                ->assertOk()
                ->assertViewIs('division.index');
        });

        it('has correct route name', function () {
            expect(route('division.index'))->toBe(url('/divisions'));
        });
    });

    describe('Division Show', function () {
        it('loads successfully with valid division', function () {
            $divisionData = json_decode(
                file_get_contents(storage_path('testing/division.json')),
                true
            );

            $divisionData['data']['division']['icon'] = 'https://example.com/icon.png';
            $divisionData['data']['division']['settings'] = ['meta_description' => 'Test description'];
            $divisionData['data']['division']['site_content'] = 'Test division content';

            Http::fake([
                '*/api/v1/divisions/cod*' => Http::response($divisionData, 200),
            ]);

            $this->get(route('division.show', 'cod'))
                ->assertOk()
                ->assertViewIs('division.show')
                ->assertViewHas('data');
        });

        it('returns 404 for invalid division', function () {
            Http::fake([
                '*/api/v1/divisions/invalid*' => Http::response(['data' => null], 200),
            ]);

            $this->get(route('division.show', 'invalid'))->assertNotFound();
        });

        it('returns 404 when API returns empty data', function () {
            Http::fake([
                '*/api/v1/divisions/empty*' => Http::response(['data' => null], 200),
            ]);

            $this->get(route('division.show', 'empty'))->assertNotFound();
        });

        it('handles API failure gracefully', function () {
            Http::fake([
                '*/api/v1/divisions/error*' => Http::response([], 500),
            ]);

            $this->get(route('division.show', 'error'))->assertNotFound();
        });

        it('includes correct query parameters in API request', function () {
            Http::fake([
                '*/api/v1/divisions/test*' => function ($request) {
                    expect($request->url())->toContain('include-site=1')
                        ->and($request->url())->toContain('include-settings=1');

                    return Http::response([
                        'data' => [
                            'division' => [
                                'name' => 'Test Division',
                                'abbreviation' => 'test',
                                'icon' => 'https://example.com/icon.png',
                                'forum_app_id' => 1,
                                'settings' => ['meta_description' => 'Test description'],
                                'site_content' => 'Test division content',
                            ],
                        ],
                    ], 200);
                },
            ]);

            $this->get(route('division.show', 'test'))->assertOk();
        });

        it('has correct route pattern', function () {
            expect(route('division.show', 'cod'))->toBe(url('/divisions/cod'))
                ->and(route('division.show', 'bf4'))->toBe(url('/divisions/bf4'));
        });
    });
});
