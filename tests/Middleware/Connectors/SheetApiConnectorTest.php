<?php

use PHPUnit\Framework\TestCase;
use Src\Middleware\Connectors\SheetApiConnector;

class SheetApiConnectorTest extends TestCase
{
    public function testGetConnectionTest(): void
    {
        $connector = new SheetApiConnector();

        $client = $connector->getConnection();
        $this->assertSame($client, $connector->getConnection());

    }
}