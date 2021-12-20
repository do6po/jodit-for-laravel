<?php

namespace Do6po\LaravelJodit\Http\Controllers;

use Do6po\LaravelJodit\Factories\FileManipulationFactory;
use Do6po\LaravelJodit\Factories\FileUploadFactory;
use Do6po\LaravelJodit\Factories\NotFoundActionException;
use Do6po\LaravelJodit\Http\Requests\FileBrowserRequest;
use Do6po\LaravelJodit\Http\Requests\FileUploadRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class JoditController extends Controller
{
    public function __construct()
    {
        if (config('jodit.need_auth')) {
            $this->middleware(config('jodit.middlewares'));
        }
    }

    /**
     * @throws NotFoundActionException
     */
    public function upload(FileUploadRequest $request, FileUploadFactory $factory): JsonResource
    {
        return $factory
            ->create($request->getDto())
            ->handle()
            ->response();
    }

    /**
     * @throws NotFoundActionException
     */
    public function browse(FileBrowserRequest $request, FileManipulationFactory $factory): JsonResource
    {
        return $factory
            ->create($request->getDto())
            ->handle()
            ->response();
    }
}
