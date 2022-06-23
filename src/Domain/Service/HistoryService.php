<?php

namespace Src\Domain\Service;

use Src\Application\Asset\History as HistoryAsset;
use Src\Domain\Entity\History;
use Src\Domain\Repository\WriteHistoryRepositoryInterface;

class HistoryService
{
    public function __construct(
        private readonly WriteHistoryRepositoryInterface $writeHistoryRepository,
    )
    {
    }

    public function create(History $history): HistoryAsset
    {
        return $this->writeHistoryRepository->writeHistory($history);
    }
}