<?php

namespace Do6po\LaravelJodit\Dto;

use Illuminate\Contracts\Support\Arrayable;

final class FolderDto implements Arrayable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var FileDto[]
     */
    private $files;

    /**
     * @var string[]
     */
    private $subFolders;

    /**
     * @param string $name
     * @param string $baseUrl
     * @param string[] $subFolders
     * @param FileDto[] $files
     * @param string|null $path
     */
    private function __construct(
        string $name,
        string $baseUrl,
        array $subFolders,
        array $files,
        string $path = null
    ) {
        $this->name = $name;
        $this->baseUrl = $baseUrl;
        $this->subFolders = $subFolders;
        $this->files = $files;
        $this->path = $path;
    }

    public static function byParams(
        string $name,
        string $baseUrl,
        array $subFolders = [],
        array $files = [],
        string $path = ''
    ): self {
        return new self(
            $name,
            $baseUrl,
            $subFolders,
            $files,
            $path
        );
    }

    public function toArray()
    {
        return [
            'baseurl' => $this->getBaseUrl(),
            'path' => $this->hasPath() ? $this->getPath() : '',
            'files' => collect($this->getFiles())->toArray(),
            'folders' => $this->getSubFolders()
        ];
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function hasPath(): bool
    {
        return !!$this->path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return FileDto[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    public function getName(): string
    {
        return $this->name ?? '.';
    }

    public function getSubFolders(): array
    {
        return $this->subFolders;
    }

}
