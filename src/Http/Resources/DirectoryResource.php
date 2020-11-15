<?php

namespace Do6po\LaravelJodit\Http\Resources;

use Do6po\LaravelJodit\Dto\FolderDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property FolderDto resource
 */
class DirectoryResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $folder = $this->resource;

        return [
            'success' => true,
            'time' => now(),
            'code' => 220,
            'data' => [
                'sources' => [
                    $folder->getName() => $folder->toArray(),
                ],
            ],
        ];
    }
}
