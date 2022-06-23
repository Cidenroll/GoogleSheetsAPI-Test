<?php

namespace Src\Middleware\Connectors;

use Src\Application\Interface\ConnectorInterface;

class RemoteFileConnector implements ConnectorInterface
{
    private string $url;
    private string $user;
    private string $pass;
    private string $remoteDir;
    private string $connection;

    public function __construct()
    {
        $this->setConnectorParameters()->setConnector();
    }

    public function setConnector(): self
    {
        $this->connection = sprintf(
            "ftp://%s:%s@%s%s%s",
            $this->user,
            $this->pass,
            rtrim($this->url, "/"),
            DIRECTORY_SEPARATOR,
            rtrim($this->remoteDir, "/")
        );

        return $this;
    }

    public function setConnectorParameters(): self
    {
        $this->user = $_ENV['REMOTE_CRED_USER'];
        $this->pass = $_ENV['REMOTE_CRED_PASS'];
        $this->url = $_ENV['REMOTE_URL'];
        $this->remoteDir = $_ENV['REMOTE_DIR'];
        return $this;
    }

    public function getRemoteFullPath(string $filename): string
    {
        return $this->connection . $filename;
    }
}