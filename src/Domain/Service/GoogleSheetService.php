<?php

namespace Src\Domain\Service;

use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Domain\Entity\History;


class GoogleSheetService
{
    public function __construct(
        private readonly GoogleSheetsAPIService $googleSheetsAPIService
    )
    {
    }

    public function createSheet(
        string $filename,
        string $locationType,
        GoogleApiSheetCollection $apiSheetCollection
    ): History
    {
        try {
            return new History(
                $filename,
                true,
                $locationType,
                $this->googleSheetsAPIService->apiSheetUpdate(
                    $this->googleSheetsAPIService->apiSheetCreate($filename),
                    $apiSheetCollection
                )
            );

        } catch (\Google\Service\Exception $e) {
            $errorMessage = (empty($e->getErrors())) ? '' : current($e->getErrors())['message'];
            return new History($filename, false, $locationType, $errorMessage);
        }
    }
}
