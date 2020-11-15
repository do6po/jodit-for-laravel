<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\PermissionsResource;

class Permissions extends AbstractFileBrowserAction
{

    public static function getActionName(): string
    {
        return 'permissions';
    }

    public function handle(): FileBrowserAction
    {
        return $this;
    }

    public function response(): PermissionsResource
    {
        return PermissionsResource::make([]);
    }
}
