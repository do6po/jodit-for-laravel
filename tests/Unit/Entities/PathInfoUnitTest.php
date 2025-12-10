<?php

namespace Do6po\LaravelJodit\Tests\Unit\Entities;

use Do6po\LaravelJodit\Entities\PathInfo;
use Do6po\LaravelJodit\Tests\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class PathInfoUnitTest extends UnitTestCase
{
    #[DataProvider('itGetExtensionSuccessDataProvider')]
    public function test_it_get_extension_success($path, $expected): void
    {
        $this->assertEquals($expected, PathInfo::byPath($path)->getExtension());
    }

    public static function itGetExtensionSuccessDataProvider(): array
    {
        return [
            ['some path/directory/file.extension', 'extension'],
            ['some path/directory/file.pdf', 'pdf'],
            ['some path/directory/file', ''],
        ];
    }
}
