<?php

namespace Service\Uploader;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Src\Application\Interface\SheetInterface;
use Src\Domain\Entity\LocalSheet;
use Src\Domain\Service\Uploader\LocalUploader;
use Src\Port\Adapters\FileGetContentsWrapper;

class LocalUploaderTest extends TestCase
{
    private const TEST_FILES_PATH = 'tests/files';

    private SheetInterface|MockObject $sheet;

    private FileGetContentsWrapper|MockObject $fileGetContentsWrapper;

    private LocalUploader $localUploader;

    public function setUp(): void
    {
        $this->sheet = $this->getMockBuilder(LocalSheet::class)->disableOriginalConstructor()->getMock();
        $this->fileGetContentsWrapper = $this->getMockBuilder(FileGetContentsWrapper::class)->disableOriginalConstructor()->getMock();

        $this->localUploader = new LocalUploader($this->sheet, $this->fileGetContentsWrapper);
    }

    public function testGetParsedXML(): void
    {
        $this->sheet->expects($this->once())->method('getLocation')->willReturn(self::TEST_FILES_PATH);
        $this->sheet->expects($this->once())->method('getFilename')->willReturn('test.xml');
        $this->fileGetContentsWrapper->expects($this->once())->method('fileGetContents')->willReturn('<?xml version="1.0" encoding="utf-8"?><catalog></catalog>');

        $this->assertInstanceOf(SimpleXMLElement::class, $this->localUploader->getParsedXML());
    }

    public function testGetParsedXMLWillThrowError(): void
    {
        $this->expectError();

        $this->sheet->expects($this->once())->method('getLocation')->willReturn('');
        $this->sheet->expects($this->once())->method('getFilename')->willReturn('');

        $this->assertInstanceOf(SimpleXMLElement::class, $this->localUploader->getParsedXML());
    }
}