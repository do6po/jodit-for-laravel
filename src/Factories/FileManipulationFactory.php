<?php

namespace Do6po\LaravelJodit\Factories;

use Do6po\LaravelJodit\Actions\FileBrowserAction;
use Do6po\LaravelJodit\Dto\FileBrowserDto;

class FileManipulationFactory
{
    /**
     * @param FileBrowserDto $dto
     * @return FileBrowserAction
     * @throws NotFoundActionException
     */
    public function create(FileBrowserDto $dto): FileBrowserAction
    {
        $action = $dto->getAction();

        foreach ($this->getActions() as $actionClass) {
            if ($actionClass::getActionName() === $action) {
                return new $actionClass($dto);
            }
        }

        throw new NotFoundActionException('Not found handler for with file browser action!');
    }

    /**
     * @return FileBrowserAction[]
     */
    private function getActions(): array
    {
        return config('jodit.file_actions');
    }
}
