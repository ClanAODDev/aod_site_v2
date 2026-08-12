<?php

declare(strict_types=1);

namespace App\Repositories\AOD;

use Illuminate\Http\Client\Response;

class FallenMemberRepository extends Repository
{
    public function all(): Response
    {
        return $this->getPromise('fallen-members');
    }
}
