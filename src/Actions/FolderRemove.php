<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\SuccessActionResource;

class FolderRemove extends AbstractFileBrowserAction
{

    public static function getActionName(): string
    {
        return 'folderRemove';
    }

    public function handle(): FileBrowserAction
    {
        $path = $this->getPath();
        $removedFolderPath = $path . DIRECTORY_SEPARATOR . $this->getName();
        $this->fileBrowser->removeDirectory($removedFolderPath);

        return $this;
    }

    public function response()
    {
        return SuccessActionResource::make([]);
    }
}
