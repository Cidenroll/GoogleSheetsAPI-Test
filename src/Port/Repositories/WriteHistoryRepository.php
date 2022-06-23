<?php

namespace Src\Port\Repositories;

use Exception;
use Src\Application\Asset\History as HistoryAsset;
use Src\Application\Exception\SheetException;
use Src\Domain\Entity\History;
use Src\Domain\Repository\WriteHistoryRepositoryInterface;
use Src\Middleware\Connectors\DatabaseConnector;

class WriteHistoryRepository implements WriteHistoryRepositoryInterface
{
    public function __construct(
        private readonly DatabaseConnector $dbConnector
    )
    {
    }

    /**
     * @throws SheetException
     */
    public function writeHistory(History $history): HistoryAsset
    {
        $fileName = $history->getFileName();
        $isUploaded = $history->isUploaded();
        $location = $history->getLocation();
        $idGoogleSpreadSheet = $history->getIdGoogleSpreadSheet();

        $statement = $this->dbConnector->getConnection()?->prepare("
            INSERT INTO history (Filename, Uploaded, Location, IdGoogleSpreadSheet)
            VALUES (:fileName, :uploaded, :location, :idGSSheet)
        ");

        $statement->bindParam(':fileName', $fileName);
        $statement->bindParam(':uploaded', $isUploaded, \PDO::PARAM_BOOL);
        $statement->bindParam(':location', $location);
        $statement->bindParam(':idGSSheet', $idGoogleSpreadSheet);

        try {
            $statement->execute();
            return new HistoryAsset(
                $this->dbConnector->getConnection()?->lastInsertId(),
                $fileName,
                $isUploaded,
                $location,
                $idGoogleSpreadSheet
            );
        } catch (Exception $e) {
            throw new SheetException("Could not save to db.");
        }
    }
}