<?php

namespace Do6po\LaravelJodit\Dto;

use Illuminate\Http\File;

final class FileUploadDto
{

    private string $action = 'fileUpload';

    private ?string $source;

    /**
     * @var string|null
     */
    private ?string $path;

    /**
     * @var File[]
     */
    private array $files;

    private ?string $url;

    private function __construct(
        string $source,
        ?string $path = null,
        array $files = [],
        ?string $url = null
    ) {
        $this->source = $source;
        $this->path = $path;
        $this->files = $files;
        $this->url = $url;
    }

    public static function byParams(
        string $source = 'default',
        ?string $path = null,
        ?array $files = [],
        ?string $url = null
    ) {
        return new self(
            $source,
            $path,
            $files,
            $url
        );
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getPath(): string
    {
        return $this->path ?? '';
    }

    public function hasPath(): bool
    {
        return !!$this->path;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getFiles(): array
    {
        return $this->files;
    }
}
