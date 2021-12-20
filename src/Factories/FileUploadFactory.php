<?php

namespace Do6po\LaravelJodit\Factories;

use Do6po\LaravelJodit\Actions\FileBrowserAction;
use Do6po\LaravelJodit\Dto\FileUploadDto;

class FileUploadFactory
{
    /**
     * @throws NotFoundActionException
     */
    public function create(FileUploadDto $dto): FileBrowserAction
    {
        $action = $dto->getAction();

        foreach ($this->getActions() as $actionClass) {
            if ($actionClass::getActionName() === $action) {
                return new $actionClass($dto);
            }
        }

        throw new NotFoundActionException('Not found handler for this file upload action!');
    }

    /**
     * @return FileBrowserAction[]
     */
    private function getActions(): array
    {
        return config('jodit.upload_actions');
    }
}
