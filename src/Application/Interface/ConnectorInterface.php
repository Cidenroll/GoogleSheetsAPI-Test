<?php

namespace Src\Application\Interface;

interface ConnectorInterface
{
    public function setConnector(): self;

    public function setConnectorParameters(): self;
}