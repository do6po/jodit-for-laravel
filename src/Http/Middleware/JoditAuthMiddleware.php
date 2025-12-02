<?php

declare(strict_types=1);

namespace Do6po\LaravelJodit\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JoditAuthMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setPathDefault();

        return $next($request);
    }

    private function setPathDefault(): void
    {
        $this->setRoot('filebrowser');
    }

    private function setRoot(string $value): void
    {
        Config::set('jodit.root', $value);
    }
}
