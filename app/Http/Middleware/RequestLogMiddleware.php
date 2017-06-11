<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Log;

/**
 * Log all HTTP requests in storage/logs/lumen.log
 **/
class RequestLogMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info("Request Logged\n" . sprintf("~~~~\n%s~~~~", (string) $request));
        return $next($request);
    }
}