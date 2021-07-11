<?php

namespace App\Repositories\AOD;

class SocialRepository extends Repository
{
    public function getTeamspeak()
    {
        return $this->getPromise('/ts-count');
    }

    public function getDiscord()
    {
        return $this->getPromise('/discord-count');
    }

    public function getStreamEvents()
    {
        return $this->getPromise('/stream-events');
    }

}
