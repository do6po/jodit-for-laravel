<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FileMove;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * @group FileBrowser
 */
class FileMoveTest extends AbstractFileBrowserTest
{

    public function test_it_move_folder_success()
    {
        $file = 'newfile1';
        $content = 'New file content';

        $this->fileBrowser->makeFile($file, $content);

        $newDir = 'dir1';

        $newFilePath = $newDir . DIRECTORY_SEPARATOR . $file;

        $this->fileBrowser->makeDirectory($newDir);

        $this->assertFalse($this->fileBrowser->exists($newFilePath));

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileMove::getActionName(),
                'source' => 'default',
                'path' => $newDir,
                'from' => $file,
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => true,
                    'data' => [
                        'code' => 220,
                    ],
                ]
            );

        $this->assertFalse($this->fileBrowser->exists($file));
        $this->assertTrue($this->fileBrowser->exists($newFilePath));
    }

    public function test_it_has_move_error_for_exists_file()
    {
        $file = 'file.txt';
        $content = 'New file content';
        $this->fileBrowser->makeFile($file, $content);

        $newDir = 'dir1';
        $this->fileBrowser->makeDirectory($newDir);

        $existFile = $newDir . DIRECTORY_SEPARATOR . $file;
        $this->fileBrowser->makeFile($existFile, $content);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileMove::getActionName(),
                'source' => 'default',
                'path' => $newDir,
                'from' => $file,
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => false,
                    'data' => [
                        'code' => 422,
                        'messages' => [
                            'dir1/file.txt - is already exists!'
                        ]
                    ],
                ]
            );
    }

    public function test_it_has_error_if_path_for_move_is_under_root()
    {
        $file = 'file.txt';
        $this->fileBrowser->makeFile($file, 'some file content text');

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileMove::getActionName(),
                'source' => 'default',
                'path' => '/../',
                'from' => $file,
            ]

        )
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson(
                [
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'path' => [
                            'path - error! Can\'t write file below root directory'
                        ]
                    ]
                ]
            );

        $this->assertFalse(Storage::exists($file));
    }

    public function test_it_get_unauthorized_error()
    {
        Config::set('jodit.need_auth', true);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileMove::getActionName(),
                'source' => 'default',
                'path' => '/../',
                'from' => 'some_path',
            ]
        )
            ->assertUnauthorized();
    }

}
