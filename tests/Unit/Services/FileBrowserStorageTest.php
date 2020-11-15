<?php

namespace Do6po\LaravelJodit\Tests\Unit\Services;

use Illuminate\Support\Facades\Config;
use Do6po\LaravelJodit\Tests\Feature\AbstractFileBrowserTest;
use Exception;
use ReflectionException;
use Do6po\LaravelJodit\Tests\Helpers\Traits\AccessModificationTrait;

/**
 * @group FileBrowser
 */
class FileBrowserStorageTest extends AbstractFileBrowserTest
{
    use AccessModificationTrait;

    public const FILE_BROWSER_ROOT = '/some/path';

    /**
     * @param $path
     * @param $expected
     * @dataProvider itConvertFullPathToRelativeDataProvider
     * @throws ReflectionException
     */
    public function test_it_convert_full_path_to_relative($path, $expected)
    {
        Config::set('jodit.root', self::FILE_BROWSER_ROOT);

        $method = $this->setMethodAsPublic($this->fileBrowser, 'convertPathFromFullToRelative');

        $this->assertEquals($expected, $method->invoke($this->fileBrowser, $path));
    }

    public function itConvertFullPathToRelativeDataProvider()
    {
        return [
            [self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative/path', 'relative/path'],
            [self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative', 'relative'],
            [self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative/path/directory/', 'relative/path/directory/'],
        ];
    }

    /**
     * @param $path
     * @param $expected
     * @throws ReflectionException
     * @dataProvider itConvertArrayOfPathsToRelativesDataProvider
     */
    public function test_it_convert_array_of_paths_to_relatives($path, $expected)
    {
        Config::set('jodit.root', self::FILE_BROWSER_ROOT);

        $method = $this->setMethodAsPublic($this->fileBrowser, 'convertPathsFromFullToRelative');

        $this->assertEquals($expected, $method->invoke($this->fileBrowser, $path));
    }

    public function itConvertArrayOfPathsToRelativesDataProvider()
    {
        return [
            [
                [
                    self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative/path',
                    self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative',
                    self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative/path/directory/',
                ],
                [
                    'relative/path',
                    'relative',
                    'relative/path/directory/',
                ]
            ]
        ];
    }

    /**
     * @param $path
     * @param $expected
     *
     * @dataProvider itGetCorrectFolderNameDataProvider
     */
    public function test_it_get_correct_folder_name($path, $expected)
    {
        $this->assertEquals($expected, $this->fileBrowser->getNameByPath($path));
    }

    public function itGetCorrectFolderNameDataProvider()
    {
        return [
            ['/some/path', 'path'],
            ['/other', 'other'],
            ['/other/path1/', 'path1'],
        ];
    }

    /**
     * @throws Exception
     */
    public function test_it_move_directory_success()
    {
        $from = 'dir1';
        $to = 'dir2';

        $this->fileBrowser->makeDirectory($from);
        $this->assertTrue($this->fileBrowser->exists($from));

        $this->assertTrue($this->fileBrowser->moveDirectory($from, $to));

        $this->assertFalse($this->fileBrowser->exists($from));
        $this->assertTrue($this->fileBrowser->exists($to));
    }

    /**
     * @throws Exception
     */
    public function test_it_move_directory_with_files_success()
    {
        $from = 'dir1';
        $to = 'dir2';
        $file = 'text_file_1.txt';
        $oldFilePath = $from . DIRECTORY_SEPARATOR . $file;
        $newFilePath = $to . DIRECTORY_SEPARATOR . $file;
        $content = 'Some text content';

        $this->fileBrowser->makeDirectory($from);
        $this->fileBrowser->makeFile($oldFilePath, $content);

        $this->assertFalse($this->fileBrowser->exists($newFilePath));

        $this->fileBrowser->moveDirectory($from, $to);

        $this->assertTrue($this->fileBrowser->exists($newFilePath));
    }

    /**
     * @param $path
     * @param $expected
     * @dataProvider itGetExtensionSuccessDataProvider
     */
    public function test_it_get_extension_success($path, $expected)
    {
        $this->assertEquals($expected, $this->fileBrowser->getExtension($path));
    }

    public function itGetExtensionSuccessDataProvider()
    {
        return [
            ['somepath/file.extension', 'extension'],
            ['somepath/file.pdf', 'pdf'],
            ['file.extension', 'extension'],
            ['buh.xls', 'xls'],
            ['buh.uchet.xls', 'xls'],
        ];
    }

    /**
     * @param $path
     * @param $expected
     * @dataProvider itGetBasicNameSuccessDataProvider
     * @throws Exception
     */
    public function test_it_get_basic_name_success($path, $expected)
    {
        $this->assertEquals($expected, $this->fileBrowser->getFileName($path));
    }

    public function itGetBasicNameSuccessDataProvider()
    {
        return [
            ['some/file.name', 'file'],
            ['some/path/file_name.with.points', 'file_name.with'],
            ['some_path.with.points/file_name.xls', 'file_name'],
            ['file_name.xls', 'file_name'],
        ];
    }

}
