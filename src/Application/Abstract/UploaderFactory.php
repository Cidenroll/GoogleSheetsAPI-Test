<?php

namespace Src\Application\Abstract;

use SimpleXMLElement;
use Src\Application\Interface\SheetInterface;
use Src\Domain\Entity\GoogleApiSheet;
use Src\Domain\Entity\GoogleApiSheetCollection;
use Src\Port\Adapters\FileGetContentsWrapper;

abstract class UploaderFactory
{
    public function __construct(
        protected readonly SheetInterface $sheet,
        protected readonly FileGetContentsWrapper $fileGetContentsWrapper
    )
    {
    }

    abstract public function getParsedXML(): ?SimpleXMLElement;

    public function prepare(): GoogleApiSheetCollection
    {
        $apiSheetCollection = new GoogleApiSheetCollection();
        foreach ($this->getParsedXML() as $element) {

            $apiSheetCollection->append(
                new GoogleApiSheet(
                    (string)$element->entity_id,
                    (float)$element->price,
                    (string)$element->link
                )
            );
        }

        return $apiSheetCollection;
    }
}