<?php

declare(strict_types=1);

namespace Do6po\LaravelJodit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JoditAuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }
}
