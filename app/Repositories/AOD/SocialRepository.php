<?php

declare(strict_types=1);

namespace App\Repositories\AOD;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SocialRepository extends Repository
{
    private const FORUM_DISCORD_URL = 'https://www.clanaod.net/forums/aodinfo.php';

    public function getDiscord(): Response
    {
        $minute = (int) floor(time() / 60) * 60;
        $token = hash_hmac('sha256', (string) $minute, config('services.aod.forum_token'));

        return Http::timeout(10)
            ->connectTimeout(5)
            ->retry(2, 200)
            ->get(self::FORUM_DISCORD_URL, [
                'type' => 'last_discord_population_json',
                'authcode2' => $token,
            ]);
    }

    public function getStreamEvents(): Response
    {
        return $this->getPromise(['stream-events']);
    }
}
