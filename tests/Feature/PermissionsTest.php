<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\Permissions;

/**
 * @group FileBrowser
 */
class PermissionsTest extends AbstractFileBrowserTest
{
    public function test_it_browse_permissions_success(): void
    {
        $this->postJson(
            route('jodit.browse'),
            [
                'action' => Permissions::getActionName(),
                'source' => 'default',
            ]

        )
            ->assertOk()
            ->assertJson(
                [
                    'success' => true,
                    'code' => 220,
                    'data' => [
                        'permissions' => [
                        ],
                    ],
                ]
            );
    }

}
