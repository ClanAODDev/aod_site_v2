<?php

namespace App\Repositories\AOD;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class DivisionRepository
{
    private string $api_endpoint = '/api/v1';

    private \Illuminate\Http\Client\PendingRequest $client;

    private string $routePrefix;

    public function __construct()
    {
        $this->client = Http::withToken(
            config('services.aod.access_token')
        )->acceptJson();

        $this->routePrefix = config('services.aod.tracker_url') . $this->api_endpoint;
    }

    public function all(): Response
    {
        return $this->client->get(
            $this->routePrefix
            . '/divisions'
        );
    }

    public function find(string $division): Response
    {
        return $this->client->get(
            $this->routePrefix
            . '/divisions/'
            . $division
        );
    }
}
