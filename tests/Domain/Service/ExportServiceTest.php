<?php

use Monolog\Test\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Domain\Entity\History;
use Src\Domain\Service\ExportService;
use Src\Domain\Service\GoogleSheetService;

class ExportServiceTest extends TestCase
{
    private GoogleSheetService|MockObject $googleSheetService;

    private ExportService $exportService;

    public function setUp(): void
    {
        $this->googleSheetService = $this->getMockBuilder(GoogleSheetService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->exportService = new ExportService($this->googleSheetService);
    }

    public function testExportSheet() :void
    {
        $historyEntity = new History('test', true, 'remote', 'abc123');

        $this->googleSheetService->expects($this->once())
            ->method('createSheet')
            ->withAnyParameters()
            ->willReturn($historyEntity);

        $result = $this->exportService->exportSheet(
            'test',
            'remote',
            new GoogleApiSheetCollection()
        );

        $this->assertSame('test', $result->getFileName());
        $this->assertSame('remote', $result->getLocation());
        $this->assertSame('abc123', $result->getIdGoogleSpreadSheet());
    }
}