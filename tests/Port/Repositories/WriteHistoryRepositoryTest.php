<?php

use PHPUnit\Framework\MockObject\MockObject;
use Src\Application\Exception\SheetException;
use Src\Domain\Entity\History;
use Src\Middleware\Connectors\DatabaseConnector;
use Src\Port\Repositories\WriteHistoryRepository;

class WriteHistoryRepositoryTest extends PHPUnit\Framework\TestCase
{
    private History|MockObject $historyEntity;

    private DatabaseConnector|MockObject $databaseConnector;

    private PDO|MockObject $PDO;

    private PDOStatement|MockObject $PDOStatement;

    private WriteHistoryRepository $writeHistoryRepository;

    public function setUp(): void
    {
        $this->historyEntity = $this->getMockBuilder(History::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->PDO = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->databaseConnector = $this->getMockBuilder(DatabaseConnector::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->PDOStatement = $this->getMockBuilder(PDOStatement::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->writeHistoryRepository = new WriteHistoryRepository($this->databaseConnector);
    }

    /**
     * @throws SheetException
     */
    public function testWriteHistoryIsFaultyConnection(): void
    {
        $this->expectError();

        $this->databaseConnector->expects($this->once())
            ->method('getConnection')
            ->willReturn($this->PDO);

        $this->historyEntity->expects($this->once())
            ->method('getFileName')
            ->willReturn('tst.txt');
        $this->historyEntity->expects($this->once())
            ->method('isUploaded')
            ->willReturn(true);
        $this->historyEntity->expects($this->once())
            ->method('getLocation')
            ->willReturn('location-test');
        $this->historyEntity->expects($this->once())
            ->method('getIdGoogleSpreadSheet')
            ->willReturn('abc123');


        $this->PDOStatement->method('bindParam')
            ->withConsecutive([':fileName', 'tst.txt'],[':uploaded', true, \PDO::PARAM_BOOL],[':location', 'location-test'], [':idGSSheet', 'abc123'])
            ->willReturnOnConsecutiveCalls(true, true, true, true);

        $this->writeHistoryRepository->writeHistory($this->historyEntity);
    }
}