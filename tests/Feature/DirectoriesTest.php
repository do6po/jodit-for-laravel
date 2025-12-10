<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\Folders;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class DirectoriesTest extends AbstractFileBrowser
{

    public function test_it_browse_directories_success(): void
    {
        $dir1 = 'dir1';
        $dir2 = 'dir2';

        $this->fileBrowser->makeDirectory($dir1);
        $this->fileBrowser->makeDirectory($dir2);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => Folders::getActionName(),
                'source' => 'default',
            ]
//

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => true,
                    'code' => 220,
                    'data' => [
                        'sources' => [
                            'default' => [
                                'baseurl' => '/storage/filebrowser/',
                                'path' => '',
                                'folders' => [
                                    '.',
                                    $dir1,
                                    $dir2,
                                ]
                            ]
                        ],
                    ],
                ]
            );
    }

    public function test_it_browse_sub_directories_success(): void
    {
        $dir1 = 'dir1';
        $dir2 = 'dir1/dir2';

        $this->fileBrowser->makeDirectory($dir1);
        $this->fileBrowser->makeDirectory($dir2);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => Folders::getActionName(),
                'source' => 'default',
                'path' => 'dir1'
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => true,
                    'code' => 220,
                    'data' => [
                        'sources' => [
                            'dir1' => [
                                'baseurl' => '/storage/filebrowser/dir1',
                                'path' => 'dir1',
                                'folders' => [
                                    '..',
                                    'dir2',
                                ]
                            ]
                        ],
                    ],
                ]
            );
    }
}
