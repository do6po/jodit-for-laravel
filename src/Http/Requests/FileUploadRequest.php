<?php

namespace Do6po\LaravelJodit\Http\Requests;

use Do6po\LaravelJodit\Dto\FileUploadDto;
use Do6po\LaravelJodit\Validators\PathValidator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\FileBag;

/**
 * @property string action
 * @property string source
 * @property string|null path
 * @property array|null|FileBag files
 * @property string|null url
 */
class FileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'path' => ['nullable', 'string', new PathValidator()],
            'source' => ['required', 'string'],
            'files' => ['sometimes', 'array'],
            'files.*' => ['sometimes', 'file'],
            'url' => ['sometimes', 'url'],
        ];
    }

    public function getDto(): FileUploadDto
    {
        return FileUploadDto::byParams(
            $this->source,
            $this->path,
            $this->files->get('files'),
            $this->url
        );
    }
}
