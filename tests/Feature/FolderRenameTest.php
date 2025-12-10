<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FolderRename;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class FolderRenameTest extends AbstractFileBrowser
{

    public function test_it_rename_folder_success(): void
    {
        $from = 'deletingDir1';
        $to = 'deletingDir2';

        $this->fileBrowser->makeDirectory($from);

        $this->assertFalse($this->fileBrowser->exists($to));

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderRename::getActionName(),
                'source' => 'default',
                'path' => '',
                'name' => $from,
                'newname' => $to,
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

        $this->assertFalse($this->fileBrowser->exists($from));
        $this->assertTrue($this->fileBrowser->exists($to));
    }

    public function test_it_rename_sub_directory_success(): void
    {
        $sub = 'sub1';

        $from = 'deletingDir1';
        $to = 'deletingDir2';

        $this->fileBrowser->makeDirectory($sub);
        $fromSub = $sub . DIRECTORY_SEPARATOR . $from;

        $toSub = $sub . DIRECTORY_SEPARATOR . $to;
        $this->fileBrowser->makeDirectory($fromSub);

        $this->assertFalse($this->fileBrowser->exists($toSub));

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderRename::getActionName(),
                'source' => 'default',
                'path' => $sub,
                'name' => $from,
                'newname' => $to,
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

        $this->assertFalse($this->fileBrowser->exists($fromSub));
        $this->assertTrue($this->fileBrowser->exists($toSub));
    }

    public function test_it_rename_file_to_exist_name(): void
    {
        $dir = 'dir';
        $this->fileBrowser->makeDirectory($dir);

        $existDir = 'exist_dir';
        $this->fileBrowser->makeDirectory($existDir);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderRename::getActionName(),
                'source' => 'default',
                'newname' => $existDir,
                'name' => $dir,
            ]
        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => false,
                    'data' => [
                        'code' => 422,
                        'messages' => [
                            '/' . $existDir . ' - is already exists!',
                        ],
                    ],
                ]
            );
    }
}
