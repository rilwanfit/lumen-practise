<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;

/**
 * 403 forbidden error when you try to say hello to hacker.
 */
class HelloMiddleware
{
    public function handle($request, Closure $next)
    {
        if (preg_match('/hacker$/i', $request->getRequestUri())) {
            return response('YOU SHALL NOT PASS!', 403);
        }

        return $next($request);
    }
}