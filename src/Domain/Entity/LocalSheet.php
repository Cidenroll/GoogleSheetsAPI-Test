<?php

namespace Src\Domain\Entity;

use Src\Application\Interface\SheetInterface;

class LocalSheet implements SheetInterface
{
    private string $location;

    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->location = $this->returnLocation();
        $this->fileName = $fileName;
    }

    public function returnLocation(): string
    {
        return $_ENV['LOCAL_URL'];
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}