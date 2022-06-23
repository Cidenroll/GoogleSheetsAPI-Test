<?php

namespace Src\Port\Adapters;

class FileGetContentsWrapper
{
    public function fileGetContents( string $filename ): bool|string
    {
        return file_get_contents( $filename );
    }
}