<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanonicalHost
{
    private const ALLOWED_HOSTS = ['www.clanaod.net', 'clanaod.net'];

    private const CANONICAL_HOST = 'www.clanaod.net';

    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('production') || in_array($request->getHost(), self::ALLOWED_HOSTS, true)) {
            return $next($request);
        }

        return redirect()->to(
            $request->getScheme() . '://' . self::CANONICAL_HOST . $request->getRequestUri(),
            301
        );
    }
}
