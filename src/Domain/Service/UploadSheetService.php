<?php

namespace Src\Domain\Service;

use Src\Application\Asset\History as HistoryAsset;
use Src\Application\Exception\SheetException;
use Src\Application\Interface\SheetInterface;
use Src\Domain\Entity\LocalSheet;
use Src\Domain\Entity\RemoteSheet;
use Src\Domain\Service\Uploader\LocalUploader;
use Src\Domain\Service\Uploader\RemoteUploader;
use Src\Port\Adapters\FileGetContentsWrapper;


class UploadSheetService
{
    public function __construct(
        private readonly HistoryService $historyService,
        private readonly ExportService $exportService,
        private readonly ValidateSheetService $validateSheetService,
        private readonly FileGetContentsWrapper $fileGetContentsWrapper
    )
    {
    }

    /**
     * @throws SheetException
     */
    public function uploadSheet(string $filename, string $locationType): ?HistoryAsset
    {
        $uploadSheet = match ($locationType) {
            SheetInterface::SHEET_LOCATION_LOCAL => new LocalSheet($filename),
            SheetInterface::SHEET_LOCATION_REMOTE => new RemoteSheet($filename)
        };

        $this->validateSheetService->validate($uploadSheet);

        if ($uploadSheet instanceof LocalSheet) {
            $historyModel = $this->exportService
                ->exportSheet(
                    $filename,
                    $locationType,
                    (new LocalUploader($uploadSheet, $this->fileGetContentsWrapper))->prepare()
                );
        } else {
            $historyModel = $this->exportService
                ->exportSheet(
                    $filename,
                    $locationType,
                    (new RemoteUploader($uploadSheet, $this->fileGetContentsWrapper))->prepare()
                );
        }

        return $this->historyService->create($historyModel);
    }
}
