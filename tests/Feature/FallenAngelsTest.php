<?php

use App\Repositories\AOD\FallenMemberRepository;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\Cache;

describe('Fallen Angels Page', function () {
    beforeEach(function () {
        Cache::flush();
    });

    it('loads successfully', function () {
        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertViewIs('pages.fallen-angels')
            ->assertViewHas('fallen');
    });

    it('has correct route name', function () {
        expect(route('fallen-angels'))->toBe(url('/fallen-angels'));
    });

    it('displays fallen members data from the tracker API', function () {
        $response = $this->get(route('fallen-angels'))->assertOk();

        $fallen = $response->viewData('fallen');

        expect($fallen)->toBeArray()->not->toBeEmpty()
            ->and($fallen[0])->toHaveKeys(['name', 'date_fallen', 'forum_profile']);
    });

    it('handles empty response from the tracker API', function () {
        $this->app->bind(FallenMemberRepository::class, fn () => new class extends FallenMemberRepository
        {
            public function __construct() {}

            public function all(): HttpResponse
            {
                return new HttpResponse(new Psr7Response(200, [], json_encode(['data' => []])));
            }
        });

        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertViewHas('fallen', []);
    });

    it('handles tracker API failure gracefully', function () {
        $this->app->bind(FallenMemberRepository::class, fn () => new class extends FallenMemberRepository
        {
            public function __construct() {}

            public function all(): HttpResponse
            {
                throw new Exception('simulated tracker outage');
            }
        });

        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertViewHas('fallen', []);
    });
});
