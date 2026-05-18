<?php

declare(strict_types=1);

namespace App\Repositories\AOD;

use Illuminate\Http\Client\Response;

class SocialRepository extends Repository
{
    public function getDiscord(): Response
    {
        return $this->getPromise(['discord-count']);
    }

    public function getStreamEvents(): Response
    {
        return $this->getPromise(['stream-events']);
    }
}
