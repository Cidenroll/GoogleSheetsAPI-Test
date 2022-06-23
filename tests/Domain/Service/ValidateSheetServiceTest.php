<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Application\Exception\SheetException;
use Src\Domain\Entity\LocalSheet;
use Src\Domain\Entity\RemoteSheet;
use Src\Domain\Service\ValidateSheetService;
use Src\Middleware\Connectors\RemoteFileConnector;

class ValidateSheetServiceTest extends TestCase
{
    private RemoteFileConnector|MockObject $connector;

    private ValidateSheetService $validateSheetService;

    public function setUp(): void
    {
        $this->connector = $this->getMockBuilder(RemoteFileConnector::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validateSheetService = new ValidateSheetService($this->connector);
    }


    public function testValidateLocalSheet(): void
    {
        try {
            $this->validateSheetService->validate((new LocalSheet('coffee_feed.xml')));
        } catch (SheetException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue(TRUE);
    }

    /**
     * @throws SheetException
     */
    public function testValidateRemoteSheetExpectConnectionError(): void
    {
        $this->expectException(SheetException::class);

        $this->connector->expects($this->once())
            ->method('getRemoteFullPath')
            ->with('test.xml')
            ->willReturn("bad!");

        $this->validateSheetService->validate((new RemoteSheet('test.xml')));

        $this->assertTrue(TRUE);
    }
}