<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\History;
use Src\Application\Asset\History as HistoryAsset;

interface WriteHistoryRepositoryInterface
{
    public function writeHistory(History $history): HistoryAsset;
}