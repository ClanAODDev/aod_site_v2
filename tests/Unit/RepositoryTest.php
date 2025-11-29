<?php

use App\Repositories\AOD\DivisionRepository;
use App\Repositories\AOD\Repository;
use App\Repositories\AOD\SocialRepository;
use Illuminate\Support\Facades\Http;

describe('AOD Repository', function () {
    beforeEach(function () {
        config([
            'services.aod.access_token' => 'test-token',
            'services.aod.tracker_url' => 'https://api.example.com',
        ]);
    });

    describe('Base Repository', function () {
        it('throws exception when access token is missing', function () {
            config(['services.aod.access_token' => null]);

            expect(fn () => new Repository)
                ->toThrow(Exception::class, 'Tracker access token missing.');
        });

        it('constructs HTTP client with correct token', function () {
            Http::fake(['*' => Http::response(['data' => 'test'], 200)]);

            $repository = new Repository;
            $reflection = new ReflectionClass($repository);
            $clientProperty = $reflection->getProperty('client');
            $clientProperty->setAccessible(true);
            $client = $clientProperty->getValue($repository);

            expect($client)->toBeInstanceOf(\Illuminate\Http\Client\PendingRequest::class);
        });

        it('builds correct API URLs', function () {
            Http::fake(['*' => Http::response(['data' => 'test'], 200)]);

            $repository = new class extends Repository
            {
                public function testGetPromise($url, $params = [])
                {
                    return $this->getPromise($url, $params);
                }
            };

            Http::assertNothingSent();

            $repository->testGetPromise('/test-endpoint');

            Http::assertSent(function ($request) {
                return $request->url() === 'https://api.example.com/api/v1/test-endpoint';
            });
        });

        it('handles array URLs correctly', function () {
            Http::fake(['*' => Http::response(['data' => 'test'], 200)]);

            $repository = new class extends Repository
            {
                public function testGetPromise($url, $params = [])
                {
                    return $this->getPromise($url, $params);
                }
            };

            $repository->testGetPromise(['divisions', 'test-division']);

            Http::assertSent(function ($request) {
                return str_contains($request->url(), 'divisions/test-division');
            });
        });

        it('adds query parameters correctly', function () {
            Http::fake(['*' => Http::response(['data' => 'test'], 200)]);

            $repository = new class extends Repository
            {
                public function testGetPromise($url, $params = [])
                {
                    return $this->getPromise($url, $params);
                }
            };

            $repository->testGetPromise('/test', ['param1' => 'value1', 'param2' => 'value2']);

            Http::assertSent(function ($request) {
                return str_contains($request->url(), 'param1=value1') &&
                       str_contains($request->url(), 'param2=value2');
            });
        });
    });

    describe('Division Repository', function () {
        it('fetches all divisions', function () {
            Http::fake(['*/api/v1/divisions' => Http::response(['data' => []], 200)]);

            $repository = new DivisionRepository;
            $response = $repository->all();

            expect($response->status())->toBe(200);
            Http::assertSent(function ($request) {
                return str_contains($request->url(), '/api/v1/divisions');
            });
        });

        it('fetches single division with correct parameters', function () {
            Http::fake(['*/api/v1/divisions/cod*' => Http::response(['data' => []], 200)]);

            $repository = new DivisionRepository;
            $response = $repository->find('cod');

            expect($response->status())->toBe(200);
            Http::assertSent(function ($request) {
                return str_contains($request->url(), '/api/v1/divisions/cod') &&
                       str_contains($request->url(), 'include-site=1') &&
                       str_contains($request->url(), 'include-settings=1');
            });
        });
    });

    describe('Social Repository', function () {
        it('fetches Discord data', function () {
            Http::fake(['*/api/v1/discord-count' => Http::response(['data' => ['count' => 100]], 200)]);

            $repository = new SocialRepository;
            $response = $repository->getDiscord();

            expect($response->status())->toBe(200);
            Http::assertSent(function ($request) {
                return str_contains($request->url(), '/api/v1/discord-count');
            });
        });
    });
});
