<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Commands\CreateFileBrowserRoot;
use Do6po\LaravelJodit\Services\FileBrowserStorage;
use Do6po\LaravelJodit\Tests\FeatureTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

abstract class AbstractFileBrowserTest extends FeatureTestCase
{
    /**
     * @var FileBrowserStorage
     */
    protected $fileBrowser;

    protected function setUp(): void
    {
        parent::setUp();

        Cache::clear();

        if (isTesting()) {
            $paths = config('jodit.root');
            Storage::deleteDirectory($paths);
        }

        Artisan::call(CreateFileBrowserRoot::class);

        $this->fileBrowser = resolve(FileBrowserStorage::class);

        Config::set('jodit.need_auth', false);
    }

}
