<?php

namespace Do6po\LaravelJodit\Actions;


use Do6po\LaravelJodit\Http\Resources\FileUploadResource;

class FileUploadRemoteAction extends AbstractFileUploadAction
{

    private array $remoteFiles = [];

    public static function getActionName(): string
    {
        return 'fileUploadRemote';
    }

    public function handle(): FileBrowserAction
    {
        return $this;
    }

    public function response(): FileUploadResource
    {
        return FileUploadResource::make($this->remoteFiles);
    }
}
