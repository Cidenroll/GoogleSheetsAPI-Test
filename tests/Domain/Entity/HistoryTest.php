<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\History;

class HistoryTest extends TestCase
{
    private History $history;

    public function setUp(): void
    {
        $this->history = new History(
            'x',
            true,
            'a',
            'yx'
        );
    }

    public function testGetAllFields(): void
    {
        $this->assertSame($this->history->getFileName(), 'x');
        $this->assertTrue($this->history->isUploaded());
        $this->assertSame($this->history->getLocation(), 'a');
        $this->assertSame($this->history->getIdGoogleSpreadSheet(), 'yx');
    }
}