<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\Files;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * @group FileBrowser
 */
class FilesTest extends AbstractFileBrowserTest
{

    public function test_it_browse_files_success()
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
                                'baseurl' => 'http://localhost/storage/filebrowser/',
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
