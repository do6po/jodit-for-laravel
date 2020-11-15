<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\FolderRemove;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * @group FileBrowser
 */
class FolderRemoveTest extends AbstractFileBrowserTest
{
    /**
     * @throws BindingResolutionException
     */
    public function test_it_delete_directory_success()
    {
        $deletingDir1 = 'deletingDir1';

        $this->fileBrowser->makeDirectory($deletingDir1);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderRemove::getActionName(),
                'source' => 'default',
                'path' => '',
                'name' => $deletingDir1
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

        $this->assertFalse($this->fileBrowser->exists($deletingDir1));
    }

    /**
     * @throws BindingResolutionException
     */
    public function test_it_remove_sub_folder_success()
    {
        $sub = 'sub1';
        $this->fileBrowser->makeDirectory($sub);

        $deletingDir1 = 'deletingDir1';

        $removingFolderPath = $sub . DIRECTORY_SEPARATOR . $deletingDir1;
        $this->fileBrowser->makeDirectory($removingFolderPath);

        $this->postJson(
            route('jodit.browse'),
            [
                'action' => FolderRemove::getActionName(),
                'source' => 'default',
                'path' => $sub,
                'name' => $deletingDir1
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

        $this->assertFalse($this->fileBrowser->exists($removingFolderPath));
    }
}
