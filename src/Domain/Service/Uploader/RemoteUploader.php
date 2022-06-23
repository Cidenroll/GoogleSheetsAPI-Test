<?php

namespace Src\Domain\Service\Uploader;

use SimpleXMLElement;
use Src\Application\Abstract\UploaderFactory;
use Src\Middleware\Connectors\RemoteFileConnector;

class RemoteUploader extends UploaderFactory
{
    public function getParsedXML(): ?SimpleXMLElement
    {
        return  simplexml_load_string(
            $this->fileGetContentsWrapper
                ->fileGetContents(
                    (
                        (new RemoteFileConnector())
                            ->getRemoteFullPath($this->sheet->getFileName()
                            )
                    )
                ),
            'SimpleXMLElement',
            LIBXML_NOCDATA
        );
    }
}