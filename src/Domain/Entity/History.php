<?php

namespace Src\Domain\Entity;

class History
{
    public function __construct(
        private readonly string $fileName,
        private readonly bool   $uploaded,
        private readonly string $location,
        private readonly string $idGoogleSpreadSheet
    )
    {
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function isUploaded(): bool
    {
        return $this->uploaded;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getIdGoogleSpreadSheet(): string
    {
        return $this->idGoogleSpreadSheet;
    }
}