<?php

declare(strict_types=1);

namespace App\Repositories\AOD;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TwitchRepository
{
    protected string $apiBase;

    protected string $oauthUrl;

    protected string $clientId;

    protected string $clientSecret;

    protected string $channel;

    public function __construct()
    {
        $this->apiBase = config('services.twitch.api_base');
        $this->oauthUrl = config('services.twitch.oauth_url');
        $this->clientId = config('services.twitch.client_id') ?? '';
        $this->clientSecret = config('services.twitch.client_secret') ?? '';
        $this->channel = config('services.twitch.channel') ?? 'clanaodstream';
    }

    protected function getAccessToken(): ?string
    {
        if (empty($this->clientId) || empty($this->clientSecret)) {
            return null;
        }

        return Cache::remember('twitch_access_token', 82800, function () {
            try {
                $response = Http::asForm()->connectTimeout(3)->timeout(5)->post($this->oauthUrl, [
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'client_credentials',
                ]);
            } catch (ConnectionException) {
                return null;
            }

            if ($response->failed()) {
                return null;
            }

            return $response->json('access_token');
        });
    }

    protected function request(string $endpoint, array $params = []): ?array
    {
        $response = $this->send($endpoint, $params);

        if ($response?->status() === 401) {
            Cache::forget('twitch_access_token');
            $response = $this->send($endpoint, $params);
        }

        if (! $response || $response->failed()) {
            return null;
        }

        return $response->json('data');
    }

    private function send(string $endpoint, array $params): ?Response
    {
        $token = $this->getAccessToken();

        if (! $token) {
            return null;
        }

        try {
            return Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Client-Id' => $this->clientId,
            ])->connectTimeout(3)->timeout(5)->get("{$this->apiBase}/{$endpoint}", $params);
        } catch (ConnectionException) {
            return null;
        }
    }

    private function rememberSuccess(string $key, int $seconds, callable $callback): mixed
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $value = $callback();

        if ($value !== null) {
            Cache::put($key, $value, $seconds);
        }

        return $value;
    }

    public function getUserId(): ?string
    {
        return Cache::rememberForever("twitch_user_id_{$this->channel}", function () {
            $users = $this->request('users', ['login' => $this->channel]);

            return $users[0]['id'] ?? null;
        });
    }

    public function isLive(): bool
    {
        return $this->getStream() !== null;
    }

    public function getStream(): ?array
    {
        $stream = $this->rememberSuccess('twitch_live_stream', 120, function () {
            $userId = $this->getUserId();

            if (! $userId) {
                return null;
            }

            $streams = $this->request('streams', ['user_id' => $userId]);

            return $streams === null ? null : ['stream' => $streams[0] ?? null];
        });

        return $stream['stream'] ?? null;
    }

    public function getVods(int $limit = 6): array
    {
        return $this->rememberSuccess('twitch_vods', (int) config('app.cache_length', 900), function () use ($limit) {
            $userId = $this->getUserId();

            if (! $userId) {
                return null;
            }

            return $this->request('videos', [
                'user_id' => $userId,
                'type' => 'archive',
                'first' => $limit,
            ]);
        }) ?? [];
    }

    public function getStreamData(): array
    {
        $isLive = $this->isLive();

        return [
            'is_live' => $isLive,
            'stream' => $isLive ? $this->getStream() : null,
            'vods' => $isLive ? [] : $this->getVods(),
            'channel' => $this->channel,
        ];
    }
}
