<?php

use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Application\Exception\SheetException;
use Src\Domain\Entity\GoogleApiSheet;
use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Domain\Entity\History;
use Src\Domain\Entity\LocalSheet;
use Src\Domain\Entity\RemoteSheet;
use Src\Domain\Service\ExportService;
use Src\Domain\Service\HistoryService;
use Src\Domain\Service\Uploader\LocalUploader;
use Src\Domain\Service\Uploader\RemoteUploader;
use Src\Domain\Service\UploadSheetService;
use Src\Domain\Service\ValidateSheetService;
use Src\Port\Adapters\FileGetContentsWrapper;

class UploadSheetServiceTest extends TestCase
{
    private HistoryService|MockObject $historyService;

    private ExportService|MockObject $exportService;

    private ValidateSheetService|MockObject $validateSheetService;

    private FileGetContentsWrapper|MockObject $fileGetContentsWrapper;

    private UploadSheetService $uploadSheetService;

    public function setUp(): void
    {
        $this->historyService = $this->getMockBuilder(HistoryService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->exportService = $this->getMockBuilder(ExportService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->validateSheetService = $this->getMockBuilder(ValidateSheetService::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->fileGetContentsWrapper = $this->getMockBuilder(FileGetContentsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->uploadSheetService = new UploadSheetService(
            $this->historyService,
            $this->exportService,
            $this->validateSheetService,
            $this->fileGetContentsWrapper
        );
    }

    /**
     * @throws SheetException
     */
    public function testUploadLocalSheet(): void
    {
        $sheet = new LocalSheet('test');
        $collection = new GoogleApiSheetCollection();
        $collection->append((new GoogleApiSheet('500', 150, 'link')));

        $this->validateSheetService->expects($this->once())
            ->method('validate')
            ->with($sheet);

        $this->fileGetContentsWrapper->expects($this->once())
            ->method('fileGetContents')
            ->with('to_upload/test')
            ->willReturn('<?xml version="1.0" encoding="utf-8"?><tag/>');

        $localUploader = $this->getMockBuilder(LocalUploader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $localUploader
            ->method('getParsedXML')
            ->willReturn(new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><test>15</test>'));

        $history = new History('test',true, 'local', '123abc');

        $this->exportService->expects($this->once())
            ->method('exportSheet')
            ->withAnyParameters()
            ->willReturn($history);

        $result = $this->uploadSheetService->uploadSheet('test', 'local');
    }
}