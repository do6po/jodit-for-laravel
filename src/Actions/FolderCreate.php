<?php

namespace Do6po\LaravelJodit\Actions;

use Do6po\LaravelJodit\Http\Resources\FileActionErrorResource;
use Do6po\LaravelJodit\Http\Resources\FolderCreatedResource;
use Do6po\LaravelJodit\Validators\DirectoryNestingValidator;
use Illuminate\Support\Facades\Validator;

class FolderCreate extends AbstractFileBrowserAction
{

    public static function getActionName(): string
    {
        return 'folderCreate';
    }

    public function handle(): FileBrowserAction
    {
        $path = $this->getPath();

        $validator = Validator::make(
            ['path' => $path],
            ['path' => [new DirectoryNestingValidator(config('jodit.nesting_limit'))]]
        );

        if ($validator->fails()) {
            $this->addError($validator->errors()->first('path'));
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
