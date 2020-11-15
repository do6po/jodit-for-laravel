<?php

namespace Do6po\LaravelJodit\Http\Requests;

use Do6po\LaravelJodit\Actions\FolderCreate;
use Do6po\LaravelJodit\Actions\FolderRemove;
use Do6po\LaravelJodit\Actions\FolderRename;
use Do6po\LaravelJodit\Dto\FileBrowserDto;
use Do6po\LaravelJodit\Validators\PathValidator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string action
 * @property string source
 * @property string|null path
 * @property string|null from
 * @property string|null name
 * @property string|null newname
 */
class FileBrowserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'action' => ['required', 'string'],
            'path' => ['nullable', 'string', new PathValidator()],
            'source' => ['required', 'string'],
            'from' => ['sometimes', 'string'],
            'name' => [$this->nameRule(), 'string'],
            'newname' => [$this->newNameRule(), 'string'],
        ];
    }

    private function nameRule(): string
    {
        return 'required_if:action,'
            . implode(
                ',',
                [
                    FolderCreate::getActionName(),
                    FolderRemove::getActionName(),
                ]
            );
    }

    private function newNameRule(): string
    {
        return 'required_if:action,' . FolderRename::getActionName();
    }

    public function getDto(): FileBrowserDto
    {
        return FileBrowserDto::byRequest($this);
    }
}
