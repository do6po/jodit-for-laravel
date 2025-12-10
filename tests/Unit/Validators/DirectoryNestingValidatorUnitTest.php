<?php

namespace Do6po\LaravelJodit\Tests\Unit\Validators;

use Do6po\LaravelJodit\Validators\DirectoryNestingValidator;
use Do6po\LaravelJodit\Tests\UnitTestCase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class DirectoryNestingValidatorUnitTest extends UnitTestCase
{
    #[DataProvider('itValidateNestingPathDataProvider')]
    public function test_it_validate_nesting_path($path, $nestingLimit, $expected): void
    {
        $validator = Validator::make(
            ['path' => $path],
            ['path' => [new DirectoryNestingValidator($nestingLimit)]]
        );

        $this->assertEquals($expected, !$validator->errors()->has('path'));
    }

    public static function itValidateNestingPathDataProvider(): array
    {
        return [
            '2 allowed, 1 passed' => ['/path', 2, true],
            '2 allowed, 3 passed' => ['/path/sub/sub', 2, false],
            '1 allowed, 1 passed' => ['/path', 1, false],
            '1 allowed, 2 passed' => ['/path/subpath', 1, false],
            '2 allowed, 2 passed' => ['/path/subpath', 2, false],
            '3 allowed, 2 passed' => ['/path/subpath', 3, true],
        ];
    }
}
