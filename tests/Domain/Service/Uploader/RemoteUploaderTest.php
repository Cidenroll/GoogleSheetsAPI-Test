<?php

namespace Service\Uploader;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;
use Src\Application\Interface\SheetInterface;
use Src\Domain\Entity\RemoteSheet;
use Src\Domain\Service\Uploader\RemoteUploader;
use Src\Port\Adapters\FileGetContentsWrapper;

class RemoteUploaderTest extends TestCase
{
    private SheetInterface|MockObject $sheet;

    private FileGetContentsWrapper|MockObject $fileGetContentsWrapper;

    private RemoteUploader $localUploader;

    public function setUp(): void
    {
        $this->sheet = $this->getMockBuilder(RemoteSheet::class)->disableOriginalConstructor()->getMock();
        $this->fileGetContentsWrapper = $this->getMockBuilder(FileGetContentsWrapper::class)->disableOriginalConstructor()->getMock();

        $this->localUploader = new RemoteUploader($this->sheet, $this->fileGetContentsWrapper);
    }

    public function testGetParsedXML(): void
    {
        $this->sheet->expects($this->once())->method('getFilename')->willReturn('test.xml');

        $this->fileGetContentsWrapper->expects($this->once())->method('fileGetContents')->willReturn('<?xml version="1.0" encoding="utf-8"?><catalog></catalog>');

        $this->assertInstanceOf(SimpleXMLElement::class, $this->localUploader->getParsedXML());
    }
}