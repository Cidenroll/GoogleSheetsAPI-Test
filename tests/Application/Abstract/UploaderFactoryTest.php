<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Application\Abstract\UploaderFactory;
use Src\Application\Interface\SheetInterface;
use Src\Domain\Entity\GoogleApiSheet;
use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Domain\Entity\LocalSheet;
use Src\Domain\Service\Uploader\LocalUploader;
use Src\Port\Adapters\FileGetContentsWrapper;

class UploaderFactoryTest extends TestCase
{
    private SheetInterface|MockObject $sheet;

    private FileGetContentsWrapper|MockObject $fileGetContentsWrapper;

    private UploaderFactory|MockObject $uploaderFactoryAbstract;

    private UploaderFactory $uploaderFactory;

    public function setUp(): void
    {
       $this->sheet = $this->getMockBuilder(LocalSheet::class)
           ->disableOriginalConstructor()
           ->getMock();

       $this->fileGetContentsWrapper = $this->getMockBuilder(FileGetContentsWrapper::class)
           ->disableOriginalConstructor()
           ->getMock();

       $this->uploaderFactoryAbstract = $this->getMockBuilder(UploaderFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

       $this->uploaderFactory = new LocalUploader($this->sheet, $this->fileGetContentsWrapper);
    }

    public function testPrepare(): void
    {
        $this->fileGetContentsWrapper->expects($this->once())
            ->method('fileGetContents')
            ->withAnyParameters()
            ->willReturn('<?xml version="1.0" encoding="utf-8"?><link>test</link>');

        $this->sheet->expects($this->once())
            ->method('getLocation')
            ->willReturn('local');


        $apiSheetCollection = new GoogleApiSheetCollection();
        $apiSheetCollection->append(
            new GoogleApiSheet('5', 15, 'link')
        );


        $result = $this->uploaderFactory->prepare();
    }
}