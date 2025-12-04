<?php

namespace Do6po\LaravelJodit\Actions;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Do6po\LaravelJodit\Dto\FileDto;
use Do6po\LaravelJodit\Dto\FolderDto;
use Do6po\LaravelJodit\Http\Resources\DirectoryResource;

class Files extends AbstractFileBrowserAction
{
    protected FolderDto $folder;

    public static function getActionName(): string
    {
        return 'files';
    }

    public function handle(): FileBrowserAction
    {
        $path = $this->getPath();

        $this->mapFiles($path);

        return $this;
    }

    protected function mapFiles(string $path): void
    {
        $files = [];

        foreach ($this->fileBrowser->files($path) as $filePath) {
            $files[] = FileDto::byAttributes(
                $this->getAttributesByPath($filePath)
            );
        }

        $this->folder = FolderDto::byParams(
            $this->fileBrowser->getNameByPath($path),
            $this->fileBrowser->getUrl('/'),
            [],
            $files,
            $path
        );
    }

    protected function getAttributesByPath(string $filePath): array
    {
        return Cache::remember(
            config('jodit.cache.key') . $filePath,
            config('jodit.cache.duration'),
            function () use ($filePath): array {
                return [
                    'fileName' => $this->getNameByFilePath($filePath),
                    'thumb' => !$this->isImage($filePath)
                        ? $this->getThumbByFilePath($filePath)
                        : null,
                    'changed' => $this->getChangedTimeByFilePath($filePath),
                    'size' => $this->getSizeByFilePath($filePath),
                ];
            }
        );
    }

    protected function getNameByFilePath(string $filePath): string
    {
        return $this->fileBrowser->getNameByPath($filePath);
    }

    private function isImage($filePath): bool
    {
        return isImage(
            $this->fileBrowser->getExtension($filePath)
        );
    }

    protected function getThumbByFilePath(string $path): string
    {
        $extension = $this->fileBrowser->getExtension($path);

        $url = config('jodit.thumb.dir_url');

        if (in_array($extension, config('jodit.thumb.exists'))) {
            return $url . sprintf(config('jodit.thumb.mask'), $extension);
        }

        return $url . config('jodit.thumb.unknown_extension');
    }

    protected function getChangedTimeByFilePath(string $filePath): Carbon
    {
        return Carbon::createFromTimestamp(
            $this->fileBrowser->lastModified($filePath)
        );
    }

    protected function getSizeByFilePath(string $filePath): int
    {
        return $this->fileBrowser->size($filePath);
    }

    public function response(): DirectoryResource
    {
        return DirectoryResource::make($this->folder);
    }
}
