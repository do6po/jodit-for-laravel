<?php

namespace Do6po\LaravelJodit\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FolderCreatedResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'success' => true,
            'time' => now(),
            'code' => 220,
            'data' => [
                'messages' => [
                    __('Directory created successfully'),
                ],
            ],
        ];
    }
}
