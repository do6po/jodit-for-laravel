<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FolderCreate;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class FolderCreateTest extends AbstractFileBrowser
{
    public function test_it_create_directory_success(): void
    {
        $newDirectory = 'newDirectory';

        $this->assertFalse($this->fileBrowser->exists($newDirectory));

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderCreate::getActionName(),
                'source' => 'default',
                'path' => '',
                'name' => $newDirectory
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => true,
                    'code' => 220,
                    'data' => [
                        'messages' => [
                            'Directory created successfully',
                        ],
                    ],
                ]
            );

        $this->assertTrue($this->fileBrowser->exists($newDirectory));
    }

    public function test_it_create_sub_directory_success(): void
    {
        $path = 'dir1';
        $this->fileBrowser->makeDirectory($path);

        $newSubDirectory = 'newSubDirectory';
        $fullDirPath = $path . DIRECTORY_SEPARATOR . $newSubDirectory;

        $this->assertFalse($this->fileBrowser->exists($fullDirPath));

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderCreate::getActionName(),
                'source' => 'default',
                'path' => $path,
                'name' => $newSubDirectory
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => true,
                    'code' => 220,
                    'data' => [
                        'messages' => [
                            'Directory created successfully',
                        ],
                    ],
                ]
            );

        $this->assertTrue($this->fileBrowser->exists($fullDirPath));
    }

    public function test_it_has_some_max_nesting_level(): void
    {
        Config::set('jodit.nesting_limit', 1);

        $path = 'dir1';
        $this->fileBrowser->makeDirectory($path);

        $newSubDirectory = 'newSubDirectory';
        $fullDirPath = $path . DIRECTORY_SEPARATOR . $newSubDirectory;

        $this->assertFalse($this->fileBrowser->exists($fullDirPath));

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderCreate::getActionName(),
                'source' => 'default',
                'path' => $path,
                'name' => $newSubDirectory
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => false,
                    'data' => [
                        'code' => 422,
                        'messages' => [
                            'Maximum directory nesting is 1',
                        ],
                    ],
                ]
            );

        $this->assertFalse($this->fileBrowser->exists($fullDirPath));
    }
}
