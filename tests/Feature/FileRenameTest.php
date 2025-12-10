<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FileRename;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class FileRenameTest extends AbstractFileBrowser
{
    public function test_it_has_rename_error_for_exists_file(): void
    {
        $file = 'file.txt';

        $this->fileBrowser->makeFile($file, 'some content');

        $existFile = 'exist_file.txt';
        $this->fileBrowser->makeFile($existFile, 'some content');

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FileRename::getActionName(),
                'source' => 'default',
                'path' => '/',
                'name' => $file,
                'newname' => $existFile,
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => false,
                    'data' => [
                        'code' => 422,
                        'messages' => [
                            '/' . $existFile . ' - is already exists!'
                        ]
                    ],
                ]
            );
    }
}
