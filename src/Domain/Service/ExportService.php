<?php

namespace Src\Domain\Service;

use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Domain\Entity\History;

class ExportService
{
    public function __construct(
        private readonly GoogleSheetService $googleApiService
    )
    {
    }

    public function exportSheet(string $filename, string $locationType, GoogleApiSheetCollection $apiSheetCollection): History
    {
        return $this->googleApiService->createSheet($filename, $locationType, $apiSheetCollection);
    }
}