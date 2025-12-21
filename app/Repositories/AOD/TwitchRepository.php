<?php

declare(strict_types=1);

namespace App\Repositories\AOD;

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
            $response = Http::asForm()->post($this->oauthUrl, [
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ]);

            if ($response->failed()) {
                return null;
            }

            return $response->json('access_token');
        });
    }

    protected function request(string $endpoint, array $params = []): ?array
    {
        $token = $this->getAccessToken();

        if (! $token) {
            return null;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'Client-Id' => $this->clientId,
        ])->get("{$this->apiBase}/{$endpoint}", $params);

        if ($response->failed()) {
            return null;
        }

        return $response->json('data');
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
        return Cache::remember('twitch_is_live', 120, function () {
            $userId = $this->getUserId();

            if (! $userId) {
                return false;
            }

            $streams = $this->request('streams', ['user_id' => $userId]);

            return ! empty($streams);
        });
    }

    public function getStream(): ?array
    {
        return Cache::remember('twitch_stream', 120, function () {
            $userId = $this->getUserId();

            if (! $userId) {
                return null;
            }

            $streams = $this->request('streams', ['user_id' => $userId]);

            return $streams[0] ?? null;
        });
    }

    public function getVods(int $limit = 6): array
    {
        return Cache::remember('twitch_vods', config('app.cache_length', 900), function () use ($limit) {
            $userId = $this->getUserId();

            if (! $userId) {
                return [];
            }

            return $this->request('videos', [
                'user_id' => $userId,
                'type' => 'archive',
                'first' => $limit,
            ]) ?? [];
        });
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
