<?php

namespace Do6po\LaravelJodit\Tests\Unit\Validators;

use Do6po\LaravelJodit\Validators\PathValidator;
use Do6po\LaravelJodit\Tests\UnitTestCase;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

#[Group('FileBrowser')]
class PathValidatorUnitTest extends UnitTestCase
{
    #[DataProvider('itValidatePathDataProvider')]
    public function test_it_validate_path($value, $expected): void
    {
        $validator = Validator::make(
            ['path' => $value],
            ['path' => [new PathValidator()]]
        );

        $this->assertEquals($expected, !$validator->errors()->has('path'));
    }

    public static function itValidatePathDataProvider(): array
    {
        return [
            ['/../', false],
            ['..', false],
            ['some_dir', true],
            ['some_dir/..', true],
            ['some_dir/../../', false],
            ['some_dir/some_dir2/../../', true],
            ['some_dir/some_dir2/../../', true],
            ['some_dir/some_dir2/../../..', false],
        ];
    }
}
