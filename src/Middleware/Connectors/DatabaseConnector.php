<?php

namespace Src\Middleware\Connectors;

use PDO;
use Src\Application\Interface\ConnectorInterface;

class DatabaseConnector implements ConnectorInterface
{
    private array $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    private PDO $connector;
    private string $dsn;
    private string $user;
    private string $pass;

    public function __construct()
    {
        $this->setConnectorParameters()->setConnector();
    }

    public function setConnector(): self
    {
        $this->connector = new PDO(
            $this->dsn,
            $this->user,
            $this->pass,
            $this->options
        );
        return $this;
    }

    public function setConnectorParameters(): self
    {
        $this->dsn = sprintf(
            "mysql:host=%s;port=%s;dbname=%s;charset=utf8",
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE']
        );
        $this->user = $_ENV['DB_USERNAME'];
        $this->pass = $_ENV['DB_PASSWORD'];
        return $this;
    }

    public function getConnection(): ?PDO
    {
        return $this->connector;
    }
}