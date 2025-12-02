<?php

declare(strict_types=1);

namespace Do6po\LaravelJodit\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class JoditPathSetterMiddleware
{

    /**
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $this->setPathDefault();

        throw new AuthenticationException('You shall not pass!');
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
