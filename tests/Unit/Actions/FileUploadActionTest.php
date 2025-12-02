<?php

namespace Do6po\LaravelJodit\Tests\Unit\Actions;

use Do6po\LaravelJodit\Actions\FileUploadAction;
use Do6po\LaravelJodit\Dto\FileUploadDto;
use Do6po\LaravelJodit\Tests\Feature\AbstractFileBrowser;
use Do6po\LaravelJodit\Tests\Helpers\Traits\AccessModificationTrait;
use ReflectionException;

/**
 * @group FileBrowser
 */
class FileUploadActionTest extends AbstractFileBrowser
{
    use AccessModificationTrait;

    /**
     * @param $name
     * @param $expected
     * @dataProvider itReplaceSpecialCharacterDataProvider
     * @throws ReflectionException
     */
    public function test_it_replace_special_character($name, $expected): void
    {
        $dto = FileUploadDto::byParams('default', '');

        $action = new FileUploadAction($dto);

        $method = $this->setMethodAsPublic($action, 'replaceSpecialCharacters');

        $this->assertEquals($expected, $method->invoke($action, $name));
    }

    public function itReplaceSpecialCharacterDataProvider(): array
    {
        return [
            ['some microsoft xls file.xls', 'some-microsoft-xls-file.xls'],
            ['some microsoft xls file.docx', 'some-microsoft-xls-file.docx'],
        ];
    }
}
