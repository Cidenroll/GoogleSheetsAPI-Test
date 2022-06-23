<?php

namespace Src\Application\Interface;

interface SheetInterface
{
    public const SHEET_LOCATION_REMOTE = 'remote';
    public const SHEET_LOCATION_LOCAL = 'local';

    public function returnLocation(): string;
}