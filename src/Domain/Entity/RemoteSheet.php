<?php

namespace Src\Domain\Entity;

use Src\Application\Interface\SheetInterface;

class RemoteSheet implements SheetInterface
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
        return $_ENV['REMOTE_URL'];
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