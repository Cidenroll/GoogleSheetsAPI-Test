<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\RemoteSheet;

class RemoteSheetTest extends TestCase
{
    private RemoteSheet $sheet;

    public function setUp(): void
    {
        $this->sheet = new RemoteSheet('test');
    }

    public function testGetAllFields(): void
    {
        $this->assertSame($this->sheet->getFileName(), 'test');
        $this->assertSame($this->sheet->getLocation(), $_ENV['REMOTE_URL']);
    }
}