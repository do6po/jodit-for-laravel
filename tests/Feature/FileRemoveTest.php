<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FileRemove;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class FileRemoveTest extends AbstractFileBrowser
{

    public function test_it_delete_file_success(): void
    {
        $file = 'deletingFile.txt';
        $content = 'File content for delete';
        $this->fileBrowser->makeFile($file, $content);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileRemove::getActionName(),
                'source' => 'default',
                'path' => '',
                'name' => $file
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
    }

    public function test_it_remove_file_from_sub_folder_success(): void
    {
        $sub = 'sub1';
        $this->fileBrowser->makeDirectory($sub);

        $file = 'file_from_sub_folder.txt';
        $content = 'File content data';
        $removingFile = $sub . DIRECTORY_SEPARATOR . $file;
        $this->fileBrowser->makeFile($removingFile, $content);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileRemove::getActionName(),
                'source' => 'default',
                'path' => $sub,
                'name' => $file
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

        $this->assertFalse($this->fileBrowser->exists($removingFile));
    }
}
