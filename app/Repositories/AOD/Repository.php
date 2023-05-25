<?php

namespace App\Repositories\AOD;

use Illuminate\Http\Client\PendingRequest;
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

        $this->client = Http::withToken($token)->acceptJson();
    }

    /**
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    protected function getPromise($url)
    {
        if (is_array($url)) {
            $url = implode('/', $url);
        }

        return $this->client->get(
            rtrim(
                config('services.aod.tracker_url'),
                '/'
            ) . $this->api_endpoint . $url
        );
    }
}
