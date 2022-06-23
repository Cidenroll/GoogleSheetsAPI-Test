<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Src\Application\Asset\History as HistoryAsset;
use Src\Domain\Entity\History;
use Src\Domain\Repository\WriteHistoryRepositoryInterface;
use Src\Domain\Service\HistoryService;
use Src\Port\Repositories\WriteHistoryRepository;

class HistoryServiceTest extends TestCase
{
    private WriteHistoryRepositoryInterface|MockObject $writeHistoryRepository;

    private HistoryService $historyService;

    public function setUp(): void
    {
        $this->writeHistoryRepository = $this->getMockBuilder(WriteHistoryRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->historyService = new HistoryService($this->writeHistoryRepository);
    }

    public function testCreate(): void
    {
        $historyEntity = new History('test', true, 'remote', '123abc');
        $historyAsset = new HistoryAsset(
            50,
            $historyEntity->getFileName(),
            $historyEntity->isUploaded(),
            $historyEntity->getLocation(),
            $historyEntity->getIdGoogleSpreadSheet()
        );

        $this->writeHistoryRepository->expects($this->once())
            ->method('writeHistory')
            ->with($historyEntity)
            ->willReturn($historyAsset);

        $result = $this->historyService->create($historyEntity);
        $this->assertInstanceOf(HistoryAsset::class, $result);
        $this->assertSame('test', $result->getFileName());
    }
}