<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\FileActionErrorResource;

class FolderMove extends AbstractFileBrowserAction
{

    public static function getActionName(): string
    {
        return 'folderMove';
    }

    public function handle(): FileBrowserAction
    {
        return $this->addError(__('Moving directories is not possible!'));
    }

    public function response()
    {
        return FileActionErrorResource::make($this->getErrors());
    }
}
