<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\SuccessActionResource;

class FileRemove extends AbstractFileBrowserAction
{

    public static function getActionName(): string
    {
        return 'fileRemove';
    }

    public function handle(): FileBrowserAction
    {
        $path = $this->getPath();
        $removingFilePath = $path . DIRECTORY_SEPARATOR . $this->getName();
        $this->fileBrowser->removeFile($removingFilePath);

        return $this;
    }

    public function response(): SuccessActionResource
    {
        return SuccessActionResource::make([]);
    }
}
