<?php

namespace Src\Middleware\Connectors;

use Google\Client;
use Google\Exception;
use Google_Service_Sheets;
use Src\Application\Interface\ConnectorInterface;

class SheetApiConnector implements ConnectorInterface
{
    private Client $client;
    private array  $scopes;
    private string $authConfig;
    private string $accessType;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->setConnectorParameters()->setConnector();
    }

    /**
     * @throws Exception
     */
    public function setConnector(): self
    {
        $this->client = new Client();
        $this->client->setApplicationName('Test GoogleAPI');
        $this->client->setScopes($this->scopes);
        $this->client->setAuthConfig($this->authConfig);
        $this->client->setAccessType($this->accessType);
        return $this;
    }

    public function setConnectorParameters(): self
    {
        $this->scopes[] = Google_Service_Sheets::SPREADSHEETS;
        $this->authConfig = $_ENV['GOOGLE_SHEETS_TOKEN_DIR'];
        $this->accessType = 'offline';
        return $this;
    }

    public function getConnection(): Client
    {
        return $this->client;
    }
}
