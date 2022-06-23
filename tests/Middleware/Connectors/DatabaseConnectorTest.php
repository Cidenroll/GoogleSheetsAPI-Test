<?php

use PHPUnit\Framework\TestCase;
use Src\Middleware\Connectors\DatabaseConnector;

class DatabaseConnectorTest extends TestCase
{
    public function testGetConnectionTest(): void
    {
        $connector = new DatabaseConnector();

        $client = $connector->getConnection();
        $this->assertSame($client, $connector->getConnection());
    }
}