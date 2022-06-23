<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\Entity\GoogleApiSheet;

class GoogleApiSheetTest extends TestCase
{
    private GoogleApiSheet $gApiSheet;

    public function setUp(): void
    {
        $this->gApiSheet = new GoogleApiSheet('550', 150, 'test-link');
    }

    public function testGetAllFields(): void
    {
        $this->assertSame('550', $this->gApiSheet->getEntityId());
        $this->assertEquals(150, $this->gApiSheet->getPrice());
        $this->assertSame('test-link', $this->gApiSheet->getLink());
    }
}