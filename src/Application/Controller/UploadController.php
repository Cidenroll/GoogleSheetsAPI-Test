<?php

namespace Src\Application\Controller;

use Src\Application\Asset\History;
use Src\Application\Exception\SheetException;
use Src\Domain\Service\UploadSheetService;

class UploadController
{
    public function __construct(
        private readonly UploadSheetService $uploadSheetService
    )
    {
    }

    /**
     * @throws SheetException
     */
    public function upload(string $filename, string $locationType): ?History
    {
        return $this->uploadSheetService->uploadSheet($filename, $locationType);
    }
}