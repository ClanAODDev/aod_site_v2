<?php

use App\Repositories\AOD\FallenMemberRepository;
use GuzzleHttp\Psr7\Response as Psr7Response;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response as HttpResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Testing\AssertableInertia;

describe('Fallen Angels Page', function () {
    beforeEach(function () {
        Cache::flush();
    });

    it('loads successfully', function () {
        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('fallen-angels')
                ->has('fallen'));
    });

    it('has correct route name', function () {
        expect(route('fallen-angels'))->toBe(url('/fallen-angels'));
    });

    it('displays fallen members data from the tracker API', function () {
        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->where('fallen', fn ($fallen) => $fallen->isNotEmpty()
                    && isset($fallen[0]['name'], $fallen[0]['date_fallen'], $fallen[0]['forum_profile'])));
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
            ->assertInertia(fn (AssertableInertia $page) => $page->where('fallen', []));
    });

    it('handles tracker API failure gracefully', function () {
        $this->app->bind(FallenMemberRepository::class, fn () => new class extends FallenMemberRepository
        {
            public function __construct() {}

            public function all(): HttpResponse
            {
                throw new ConnectionException('simulated tracker outage');
            }
        });

        $this->get(route('fallen-angels'))
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $page) => $page->where('fallen', []));
    });
});
