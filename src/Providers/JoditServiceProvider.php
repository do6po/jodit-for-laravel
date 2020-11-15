<?php

namespace Do6po\LaravelJodit\Providers;

use Do6po\LaravelJodit\Commands\CreateFileBrowserRoot;
use Illuminate\Support\ServiceProvider;

class JoditServiceProvider extends ServiceProvider
{

    public function register(): void
    {
    }

    public function boot(): void
    {
        $this->config();

        $this->routes();

        $this->commands(
            [
                CreateFileBrowserRoot::class,
            ]
        );
    }

    private function config(): void
    {
        $configPath = __DIR__ . '/../../config/jodit.php';

        $this->publishes(
            [
                $configPath => config_path('jodit.php'),
            ],
            'config'
        );

        $this->mergeConfigFrom($configPath, 'jodit');
    }

    private function routes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/jodit.php');
    }
}
