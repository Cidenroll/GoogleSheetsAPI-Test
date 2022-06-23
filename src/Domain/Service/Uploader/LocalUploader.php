<?php

namespace Src\Domain\Service\Uploader;

use SimpleXMLElement;
use Src\Application\Abstract\UploaderFactory;

class LocalUploader extends UploaderFactory
{
    public function getParsedXML(): ?SimpleXMLElement
    {
        return simplexml_load_string(
            $this->fileGetContentsWrapper->fileGetContents(
                sprintf("%s/%s", rtrim($this->sheet->getLocation(), "/"), $this->sheet->getFilename())
            ),
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );
    }
}