<?php

describe('Fallen Angels Page', function () {
    it('loads successfully', function () {
        $response = $this->get(route('fallen-angels'));

        $response->assertOk();
        $response->assertViewIs('pages.fallen-angels');
        $response->assertViewHas('fallen');
    });

    it('has correct route name', function () {
        expect(route('fallen-angels'))->toBe(url('/fallen-angels'));
    });

    it('displays fallen angels data from config', function () {
        config(['aod.fallen-angels' => [
            ['name' => 'John Doe', 'rank' => 'General', 'date_of_death' => '2023-01-01', 'forum_profile' => 'https://example.com/profile/1'],
            ['name' => 'Jane Smith', 'rank' => 'Colonel', 'date_of_death' => '2023-02-01', 'forum_profile' => 'https://example.com/profile/2'],
        ]]);

        $response = $this->get(route('fallen-angels'));

        $response->assertOk();
        $response->assertViewHas('fallen', [
            ['name' => 'John Doe', 'rank' => 'General', 'date_of_death' => '2023-01-01', 'forum_profile' => 'https://example.com/profile/1'],
            ['name' => 'Jane Smith', 'rank' => 'Colonel', 'date_of_death' => '2023-02-01', 'forum_profile' => 'https://example.com/profile/2'],
        ]);
    });

    it('handles empty fallen angels config', function () {
        config(['aod.fallen-angels' => []]);

        $response = $this->get(route('fallen-angels'));

        $response->assertOk();
        $response->assertViewHas('fallen', []);
    });

    it('uses default config when no custom config is set', function () {
        $response = $this->get(route('fallen-angels'));

        $response->assertOk();
        $response->assertViewHas('fallen');

        $fallen = $response->viewData('fallen');
        expect($fallen)->toBeArray();
        expect(count($fallen))->toBeGreaterThan(0);
        expect($fallen[0])->toHaveKey('name');
        expect($fallen[0])->toHaveKey('date_of_death');
        expect($fallen[0])->toHaveKey('forum_profile');
    });
});
