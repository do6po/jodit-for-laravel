<?php

use Do6po\LaravelJodit\Http\Controllers\JoditController;

$route = Route::middleware(config('jodit.routes.middleware'));

if ($prefix = config('jodit.routes.prefix')) {
    $route->prefix($prefix);
}

$route->group(
    function () use($route) {
        $route->post(
            config('jodit.routes.browse_path'),
            [
                JoditController::class,
                'browse'
            ]
        )
            ->name(config('jodit.routes.browse_name'));

        $route->post(
            config('jodit.routes.upload_path'),
            [
                JoditController::class,
                'upload'
            ]
        )
            ->name(config('jodit.routes.upload_name'));
    }
);
