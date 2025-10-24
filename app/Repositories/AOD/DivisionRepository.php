<?php

namespace App\Repositories\AOD;

use Illuminate\Http\Client\Response;

class DivisionRepository extends Repository
{
    public function all(): Response
    {
        return $this->getPromise('/divisions');
    }

    public function find(string $division): Response
    {
        return $this->getPromise(
            ['divisions', $division],
            ['include-site' => true, 'include-settings' => true]
        );
    }
}
