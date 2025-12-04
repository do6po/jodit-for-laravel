<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\SuccessActionResource;

class FileMove extends AbstractFileBrowserAction
{

    /**
     * @return FileBrowserAction
     */
    public function handle(): FileBrowserAction
    {
        $from = $this->getFrom();
        $fileName = $this->fileBrowser->getNameByPath($this->getFrom());
        $to = $this->getPath() . DIRECTORY_SEPARATOR . $fileName;

        $this->checkPathExists($to);

        if ($this->hasErrors()) {
            return $this;
        }

        $this->fileBrowser->moveFile($from, $to);

        return $this;
    }

    public function response()
    {
        if ($this->hasErrors()) {
            return $this->getErrorResponse();
        }

        return SuccessActionResource::make(null);
    }

    public static function getActionName(): string
    {
        return 'fileMove';
    }
}
