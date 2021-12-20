<?php

namespace Do6po\LaravelJodit\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateFileBrowserRoot extends Command
{
    protected $signature = 'do6po:jodit:create-filebrowser-root';

    protected $description = 'Create base root directory for Jodit file browser.';

    public function handle(): void
    {
        $path = config('jodit.root');

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);

            $this->info('Root for file browser is created!');

            return;
        }

        $this->info('Root for file browser is exists!');
    }
}
