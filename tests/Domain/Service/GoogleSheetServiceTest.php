<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Domain\Entity\History;
use Src\Domain\Service\GoogleSheetsAPIService;
use Src\Domain\Service\GoogleSheetService;
use Google\Service\Sheets\Spreadsheet;

class GoogleSheetServiceTest extends TestCase
{
    private GoogleSheetsAPIService|MockObject $googleSheetsAPIService;

    private GoogleSheetService $googleSheetService;

    public function setUp(): void
    {
        $this->googleSheetsAPIService = $this->getMockBuilder(GoogleSheetsAPIService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->googleSheetService = new GoogleSheetService($this->googleSheetsAPIService);
    }

    public function testCreateSheetIsSuccessful(): void
    {
        $spreadSheet = new SpreadSheet(['properties' => ['title' => 'test']]);
        $this->googleSheetsAPIService->expects($this->once())
            ->method('apiSheetCreate')
            ->with('test')
            ->willReturn($spreadSheet);

        $this->googleSheetsAPIService->expects($this->once())
            ->method('apiSheetUpdate')
            ->withAnyParameters()
            ->willReturn('abc123');

        $result = $this->googleSheetService->createSheet(
            'test',
            'remote',
            new GoogleApiSheetCollection()
        );

        $this->assertInstanceOf(History::class, $result);
        $this->assertSame('test', $result->getFileName());
        $this->assertSame('abc123', $result->getIdGoogleSpreadSheet());
        $this->assertSame('remote', $result->getLocation());
    }

    public function testCreateSheetExpectException(): void
    {
        $this->googleSheetsAPIService->expects($this->once())
            ->method('apiSheetCreate')
            ->with('test')
            ->willThrowException(new \Google\Service\Exception(''));

        $result = $this->googleSheetService->createSheet(
            'test',
            'remote',
            new GoogleApiSheetCollection()
        );

        $this->assertSame('', $result->getIdGoogleSpreadSheet());
        $this->assertFalse($result->isUploaded());
    }
}
