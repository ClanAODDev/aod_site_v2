<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Support\OnSiteDivisions;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    private const FOUNDED = 1999;

    protected $rootView = 'app';

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'divisions' => fn () => OnSiteDivisions::get(),
            'foundedYear' => self::FOUNDED,
            'currentYear' => fn () => (int) now()->year,
        ];
    }
}
