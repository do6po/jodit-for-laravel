<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Actions\Permissions;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * @group FileBrowser
 */
class PermissionsTest extends AbstractFileBrowserTest
{

    /**
     * @throws BindingResolutionException
     */
    public function test_it_browse_permissions_success()
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
