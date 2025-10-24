<?php

namespace App\Repositories\AOD;

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

        if (!$token) {
            throw new \Exception('Tracker access token missing.');
        }

        $this->client = Http::withToken($token)
            ->acceptJson();
    }

    /**
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    protected function getPromise(string|array $url, array $params = []): Response
    {
        $base = rtrim(config('services.aod.tracker_url'), '/');
        $endpoint = trim($this->api_endpoint, '/');

        $path = is_array($url) ? implode('/', array_map('rawurlencode', $url)) : ltrim($url, '/');

        $fullUrl = "{$base}/{$endpoint}/{$path}";

        if (!empty($params)) {
            $query = http_build_query($params);
            $fullUrl .= "?{$query}";
        }

        return $this->client->get($fullUrl);
    }
}
