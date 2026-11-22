<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePrototypeAccess
{
    public const COOKIE = 'aod_prototype';

    private const COOKIE_MINUTES = 60 * 24 * 30;

    public function handle(Request $request, Closure $next): Response
    {
        $key = (string) config('aod.prototype.access_key');

        abort_if($key === '', 404);

        $grant = hash_hmac('sha256', $key, (string) config('app.key'));

        if (is_string($request->query('key')) && hash_equals($key, $request->query('key'))) {
            return redirect()
                ->to($request->fullUrlWithoutQuery('key'))
                ->withCookie(cookie(self::COOKIE, $grant, self::COOKIE_MINUTES, httpOnly: true, sameSite: 'lax'))
                ->header('X-Robots-Tag', 'noindex, nofollow');
        }

        abort_unless(hash_equals($grant, (string) $request->cookie(self::COOKIE)), 404);

        $response = $next($request);
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $response;
    }
}
