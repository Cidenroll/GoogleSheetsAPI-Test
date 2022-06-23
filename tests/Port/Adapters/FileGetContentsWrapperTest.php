<?php

use PHPUnit\Framework\TestCase;
use Src\Port\Adapters\FileGetContentsWrapper;

class FileGetContentsWrapperTest extends TestCase
{
    public function testFileGetContentsExpectsError(): void
    {
        $this->expectError();
        $this->assertIsBool((new FileGetContentsWrapper())->fileGetContents(''));
    }

    public function testFileGetContentsReturnsBool(): void
    {
        $this->assertIsString((new FileGetContentsWrapper())->fileGetContents('tests/files/test.xml'));
    }
}