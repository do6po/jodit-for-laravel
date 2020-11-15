<?php

namespace Do6po\LaravelJodit\Actions;

interface FileBrowserAction
{
    public static function getActionName(): string;

    public function handle(): self;

    public function response();
}
