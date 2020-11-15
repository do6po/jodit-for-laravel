<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\FileActionErrorResource;
use Do6po\LaravelJodit\Http\Resources\FolderCreatedResource;
use Do6po\LaravelJodit\Validators\DirectoryNestingValidator;

class FolderCreate extends AbstractFileBrowserAction
{

    public static function getActionName(): string
    {
        return 'folderCreate';
    }

    public function handle(): FileBrowserAction
    {
        $path = $this->getPath();

        $directoryNestingValidator = new DirectoryNestingValidator(config('jodit.nesting_limit'));
        if (!$directoryNestingValidator->passes('path', $path)) {
            $this->addError($directoryNestingValidator->message());

            return $this;
        }

        $newFolderPath = $path . DIRECTORY_SEPARATOR . $this->getName();
        $this->fileBrowser->makeDirectory($newFolderPath);

        return $this;
    }

    public function response()
    {
        if ($this->hasErrors()) {
            return FileActionErrorResource::make($this->getErrors());
        }

        return FolderCreatedResource::make([]);
    }
}
