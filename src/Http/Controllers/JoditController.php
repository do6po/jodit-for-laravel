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
     * @param FileUploadRequest $request
     * @param FileUploadFactory $factory
     * @return JsonResource
     * @throws NotFoundActionException
     */
    public function upload(FileUploadRequest $request, FileUploadFactory $factory)
    {
        return $factory
            ->create($request->getDto())
            ->handle()
            ->response();
    }

    /**
     * @param FileBrowserRequest $request
     * @param FileManipulationFactory $factory
     * @return JsonResource
     * @throws NotFoundActionException
     */
    public function browse(FileBrowserRequest $request, FileManipulationFactory $factory)
    {
        return $factory
            ->create($request->getDto())
            ->handle()
            ->response();
    }
}
