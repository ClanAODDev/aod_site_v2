<?php

declare(strict_types=1);

namespace App\Repositories\AOD;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Repository
{
    protected string $api_endpoint = '/api/v1';

    protected PendingRequest $client;

    public function __construct()
    {
        $token = config('services.aod.access_token');

        if (! $token) {
            throw new \Exception('Tracker access token missing.');
        }

        $this->client = Http::withToken($token)
            ->acceptJson()
            ->connectTimeout(3)
            ->timeout(5);
    }

    /**
     * @return PromiseInterface|Response
     */
    protected function getPromise(string|array $url, array $params = []): Response
    {
        $base = rtrim(config('services.aod.tracker_url'), '/');
        $endpoint = trim($this->api_endpoint, '/');

        $path = is_array($url) ? implode('/', array_map('rawurlencode', $url)) : ltrim($url, '/');

        return $this->client->get("{$base}/{$endpoint}/{$path}", $params);
    }
}
