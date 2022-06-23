<?php

namespace Src\Domain\Entity;

class GoogleApiSheet
{
    public function __construct(
        private readonly string $entityId,
        private readonly float  $price,
        private readonly string $link
    )
    {
    }

    public function getEntityId(): string
    {
        return $this->entityId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getLink(): string
    {
        return $this->link;
    }
}