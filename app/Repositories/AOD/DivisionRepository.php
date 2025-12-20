<?php

declare(strict_types=1);

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
            url: ['divisions', $division],
            params: [
                'include-site' => true,
                'include-settings' => true,
                'include-screenshots' => true,
            ]
        );
    }
}
