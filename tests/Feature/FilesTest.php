<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\Files;

/**
 * @group FileBrowser
 */
class FilesTest extends AbstractFileBrowser
{

    public function test_it_browse_files_success(): void
    {
        $str = 'file1.txt';
        $this->fileBrowser->put($str, 'some text');

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => Files::getActionName(),
                'source' => 'default',
            ]

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
                                'files' => [
                                    [
                                        'file' => 'file1.txt',
                                        'size' => '0.009 kb',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            );
    }

}
