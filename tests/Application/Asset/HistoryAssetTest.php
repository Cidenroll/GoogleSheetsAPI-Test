<?php

use PHPUnit\Framework\TestCase;
use Src\Application\Asset\History;


class HistoryAssetTest extends TestCase
{
    private History $history;

    public function setUp(): void
    {
        $this->history = new History(
            1,
            'x',
            true,
            'a',
            'yx'
        );
    }

    public function testGetAllFields(): void
    {
        $this->assertSame(1, $this->history->getIdHistory());
        $this->assertSame('x', $this->history->getFileName());
        $this->assertTrue($this->history->isUploaded());
        $this->assertSame('a', $this->history->getLocation());
        $this->assertSame('yx', $this->history->getIdGoogleSpreadSheet());
    }
}