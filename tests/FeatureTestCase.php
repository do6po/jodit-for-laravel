<?php

namespace Do6po\LaravelJodit\Tests;

use Do6po\LaravelJodit\Providers\JoditServiceProvider;
use Orchestra\Testbench\TestCase;

class FeatureTestCase extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            JoditServiceProvider::class,
        ];
    }
}
