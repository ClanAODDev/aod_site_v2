<?php

describe('Fallen Angels Page', function () {
    it('loads successfully', function () {
        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertViewIs('pages.fallen-angels')
            ->assertViewHas('fallen');
    });

    it('has correct route name', function () {
        expect(route('fallen-angels'))->toBe(url('/fallen-angels'));
    });

    it('displays fallen angels data from config', function () {
        config(['aod.fallen-angels' => [
            ['name' => 'John Doe', 'rank' => 'General', 'date_of_death' => '2023-01-01', 'forum_profile' => 'https://example.com/profile/1'],
            ['name' => 'Jane Smith', 'rank' => 'Colonel', 'date_of_death' => '2023-02-01', 'forum_profile' => 'https://example.com/profile/2'],
        ]]);

        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertViewHas('fallen', [
                ['name' => 'John Doe', 'rank' => 'General', 'date_of_death' => '2023-01-01', 'forum_profile' => 'https://example.com/profile/1'],
                ['name' => 'Jane Smith', 'rank' => 'Colonel', 'date_of_death' => '2023-02-01', 'forum_profile' => 'https://example.com/profile/2'],
            ]);
    });

    it('handles empty fallen angels config', function () {
        config(['aod.fallen-angels' => []]);

        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertViewHas('fallen', []);
    });

    it('uses default config when no custom config is set', function () {
        $response = $this->get(route('fallen-angels'))->assertOk()->assertViewHas('fallen');

        $fallen = $response->viewData('fallen');

        expect($fallen)->toBeArray()->not->toBeEmpty()
            ->and($fallen[0])->toHaveKeys(['name', 'date_of_death', 'forum_profile']);
    });
});
