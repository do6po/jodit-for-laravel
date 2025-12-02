<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FolderMove;

class FolderMoveTest extends AbstractFileBrowser
{
    public function test_it_move_folder_to_other_folder_success(): void
    {
        $dir1 = 'dir1';
        $dir2 = 'dir2';

        $this->fileBrowser->makeDirectory($dir1);
        $this->fileBrowser->makeDirectory($dir2);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderMove::getActionName(),
                'source' => 'default',
                'path' => $dir2,
                'from' => $dir1,
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => false,
                    'data' => [
                        'code' => 422,
                        'messages' => [
                            'Moving directories is not possible!',
                        ]
                    ],
                ]
            );
    }
}
