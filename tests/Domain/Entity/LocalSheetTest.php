<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\LocalSheet;

class LocalSheetTest extends TestCase
{
    private LocalSheet $sheet;

    public function setUp(): void
    {
        $this->sheet = new LocalSheet('test');
    }

    public function testGetAllFields(): void
    {
        $this->assertSame($this->sheet->getFileName(), 'test');
        $this->assertSame($this->sheet->getLocation(), $_ENV['LOCAL_URL']);
    }
}