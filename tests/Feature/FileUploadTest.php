<?php

namespace Do6po\LaravelJodit\Tests\Feature;

use Do6po\LaravelJodit\Http\Middleware\JoditAuthMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Component\HttpFoundation\Response;

#[Group('FileBrowser')]
class FileUploadTest extends AbstractFileBrowser
{

    public function test_it_try_to_upload_image_and_has_unauthorized_error(): void
    {
        Config::set('jodit.need_auth', true);
        $this->mock(
            JoditAuthMiddleware::class,
            fn(MockInterface $mock) => $mock
                ->shouldReceive('handle')
                ->once()
                ->andThrow(new AuthenticationException('You shall not pass!'))
        );

        $fileName = 'image_name.jpg';
        $file = UploadedFile::fake()->image($fileName);

        $this->postJson(
            route('jodit.upload'),
            [
                'source' => 'default',
                'files' => [
                    $file,
                ],
            ]
        )
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_it_upload_image_success(): void
    {
        $fileName = 'image-name.jpg';
        $file = UploadedFile::fake()->image($fileName);

        $this->assertFalse($this->fileBrowser->exists($fileName));

        $this->postJson(
            route('jodit.upload'),
            [
                'source' => 'default',
                'files' => [
                    $file,
                ],
            ]

        )
            ->assertOk();

        $this->assertTrue($this->fileBrowser->exists($fileName));
    }

    #[DataProvider('uploadDifferentFormatsDataProvider')]
    public function test_it_upload_different_file_success($fileName, $expected): void
    {
        $file = UploadedFile::fake()->create($fileName);

        $this->assertFalse($this->fileBrowser->exists($expected));

        $this->postJson(
            route('jodit.upload'),
            [
                'source' => 'default',
                'files' => [
                    $file,
                ],
            ]

        )
            ->assertOk();

        $this->assertTrue($this->fileBrowser->exists($expected));
    }

    public static function uploadDifferentFormatsDataProvider(): array
    {
        return [
            ['file-name.txt', 'file-name.txt'],
            ['some-microsoft-xls-file.xls', 'some-microsoft-xls-file.xls'],
            ['some-microsoft-docx-file.docx', 'some-microsoft-docx-file.docx'],
            ['some-microsoft-docx-file.docx.vnd', 'some-microsoft-docx-file.docx'],
        ];
    }
}
