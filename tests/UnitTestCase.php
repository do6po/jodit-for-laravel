<?php

namespace Do6po\LaravelJodit\Tests;

use Do6po\LaravelJodit\Providers\JoditServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class UnitTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            JoditServiceProvider::class,
        ];
    }
}
