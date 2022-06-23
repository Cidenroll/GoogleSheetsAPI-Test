<?php

use Google\Service\Sheets;
use PHPUnit\Framework\TestCase;
use Src\Domain\Service\GoogleSheetsAPIService;
use Src\Middleware\Connectors\SheetApiConnector;

class GoogleSheetsApiServiceTest extends TestCase
{
    public function testApiGetSheet(): void
    {
        $connector = $this->getMockBuilder(SheetApiConnector::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(Sheets::class, (new GoogleSheetsAPIService($connector))->getSheets());
    }
}