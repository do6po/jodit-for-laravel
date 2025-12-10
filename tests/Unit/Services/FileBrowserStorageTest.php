<?php

namespace Do6po\LaravelJodit\Tests\Unit\Services;

use Illuminate\Support\Facades\Config;
use Do6po\LaravelJodit\Tests\Feature\AbstractFileBrowser;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use ReflectionException;
use Do6po\LaravelJodit\Tests\Helpers\Traits\AccessModificationTrait;

#[Group('FileBrowser')]
class FileBrowserStorageTest extends AbstractFileBrowser
{
    use AccessModificationTrait;

    public const FILE_BROWSER_ROOT = '/some/path';

    /**
     * @throws ReflectionException
     */
    #[DataProvider('itConvertFullPathToRelativeDataProvider')]
    public function test_it_convert_full_path_to_relative($path, $expected): void
    {
        Config::set('jodit.root', self::FILE_BROWSER_ROOT);

        $method = $this->setMethodAsPublic($this->fileBrowser, 'convertPathFromFullToRelative');

        $this->assertEquals($expected, $method->invoke($this->fileBrowser, $path));
    }

    public static function itConvertFullPathToRelativeDataProvider(): array
    {
        return [
            [self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative/path', 'relative/path'],
            [self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative', 'relative'],
            [self::FILE_BROWSER_ROOT . DIRECTORY_SEPARATOR . 'relative/path/directory/', 'relative/path/directory/'],
        ];
    }

    /**
     * @throws ReflectionException
     */
    #[DataProvider('itConvertArrayOfPathsToRelativesDataProvider')]
    public function test_it_convert_array_of_paths_to_relatives($path, $expected): void
    {
        Config::set('jodit.root', self::FILE_BROWSER_ROOT);

        $method = $this->setMethodAsPublic($this->fileBrowser, 'convertPathsFromFullToRelative');

        $this->assertEquals($expected, $method->invoke($this->fileBrowser, $path));
    }

    public static function itConvertArrayOfPathsToRelativesDataProvider(): array
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

    #[DataProvider('itGetCorrectFolderNameDataProvider')]
    public function test_it_get_correct_folder_name($path, $expected): void
    {
        $this->assertEquals($expected, $this->fileBrowser->getNameByPath($path));
    }

    public static function itGetCorrectFolderNameDataProvider(): array
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
    public function test_it_move_directory_success(): void
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
    public function test_it_move_directory_with_files_success(): void
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

    #[DataProvider('itGetExtensionSuccessDataProvider')]
    public function test_it_get_extension_success($path, $expected): void
    {
        $this->assertEquals($expected, $this->fileBrowser->getExtension($path));
    }

    public static function itGetExtensionSuccessDataProvider(): array
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
     * @throws Exception
     */
    #[DataProvider('itGetBasicNameSuccessDataProvider')]
    public function test_it_get_basic_name_success($path, $expected): void
    {
        $this->assertEquals($expected, $this->fileBrowser->getFileName($path));
    }

    public static function itGetBasicNameSuccessDataProvider(): array
    {
        return [
            ['some/file.name', 'file'],
            ['some/path/file_name.with.points', 'file_name.with'],
            ['some_path.with.points/file_name.xls', 'file_name'],
            ['file_name.xls', 'file_name'],
        ];
    }

}
