<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Application\Asset\History;
use Src\Application\Controller\UploadController;
use Src\Application\Exception\SheetException;
use Src\Domain\Service\UploadSheetService;

class UploadControllerTest extends TestCase
{
    private UploadSheetService|MockObject $uploadSheetService;

    private UploadController $uploadController;

    public function setUp(): void
    {
        $this->uploadSheetService = $this->getMockBuilder(UploadSheetService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->uploadController = new UploadController($this->uploadSheetService);
    }

    /**
     * @throws SheetException
     */
    public function testUpload(): void
    {
        $historyAsset = new History(1, 'test', true, 'local', '123abc');

        $this->uploadSheetService->expects($this->once())
            ->method('uploadSheet')
            ->with('test', 'local')
            ->willReturn($historyAsset);

        $result = $this->uploadController->upload('test', 'local');

        $this->assertSame($historyAsset->getFileName(), $result->getFileName());
        $this->assertSame($historyAsset->getIdGoogleSpreadSheet(), $result->getIdGoogleSpreadSheet());
    }
}