<?php

use App\Repositories\AOD\TwitchRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

describe('Twitch repository', function () {
    beforeEach(function () {
        Cache::flush();
        config([
            'services.twitch.client_id' => 'client',
            'services.twitch.client_secret' => 'secret',
            'services.twitch.channel' => 'clanaodstream',
        ]);
        Cache::forever('twitch_user_id_clanaodstream', '133295976');
    });

    it('replaces a token Twitch has revoked and still sees the live stream', function () {
        Cache::put('twitch_access_token', 'revoked', 82800);

        Http::fake([
            'id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'fresh']),
            'api.twitch.tv/helix/streams*' => function ($request) {
                return $request->hasHeader('Authorization', 'Bearer revoked')
                    ? Http::response(['error' => 'Unauthorized', 'status' => 401, 'message' => 'Invalid OAuth token'], 401)
                    : Http::response(['data' => [['title' => 'Raid night', 'game_name' => 'World of Warcraft', 'viewer_count' => 12]]]);
            },
        ]);

        $data = (new TwitchRepository)->getStreamData();

        expect($data['is_live'])->toBeTrue()
            ->and($data['stream']['game_name'])->toBe('World of Warcraft')
            ->and(Cache::get('twitch_access_token'))->toBe('fresh');
    });

    it('does not cache a failed lookup as offline', function () {
        Cache::put('twitch_access_token', 'fresh', 82800);

        Http::fakeSequence('api.twitch.tv/helix/streams*')
            ->push(['message' => 'Service unavailable'], 503)
            ->push(['data' => [['title' => 'Back up', 'game_name' => 'Dune', 'viewer_count' => 3]]]);

        $repository = new TwitchRepository;

        expect($repository->isLive())->toBeFalse()
            ->and($repository->isLive())->toBeTrue();
    });

    it('caches a successful offline answer', function () {
        Cache::put('twitch_access_token', 'fresh', 82800);

        Http::fake([
            'api.twitch.tv/helix/streams*' => Http::response(['data' => []]),
        ]);

        $repository = new TwitchRepository;
        $repository->isLive();
        $repository->isLive();

        Http::assertSentCount(1);
    });

    it('does not cache a failed broadcast list as empty', function () {
        Cache::put('twitch_access_token', 'fresh', 82800);

        Http::fakeSequence('api.twitch.tv/helix/videos*')
            ->push(['message' => 'Service unavailable'], 503)
            ->push(['data' => [['url' => 'https://www.twitch.tv/videos/1', 'title' => 'Raid', 'thumbnail_url' => '', 'duration' => '1h', 'view_count' => 5]]]);

        $repository = new TwitchRepository;

        expect($repository->getVods())->toBe([])
            ->and($repository->getVods())->toHaveCount(1);
    });
});
