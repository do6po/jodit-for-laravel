<?php

namespace Do6po\LaravelJodit\Tests\Unit\Entities;

use Do6po\LaravelJodit\Entities\PathInfo;
use Do6po\LaravelJodit\Tests\UnitTestCase;

/**
 * @group FileBrowser
 */
class PathInfoUnitTest extends UnitTestCase
{
    /**
     * @param $path
     * @param $expected
     * @dataProvider itGetExtensionSuccessDataProvider
     */
    public function test_it_get_extension_success($path, $expected)
    {
        $this->assertEquals($expected, PathInfo::byPath($path)->getExtension());
    }

    public function itGetExtensionSuccessDataProvider()
    {
        return [
            ['some path/directory/file.extension', 'extension'],
            ['some path/directory/file.pdf', 'pdf'],
            ['some path/directory/file', ''],
        ];
    }
}
