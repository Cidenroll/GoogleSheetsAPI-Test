<?php

declare(strict_types = 1);

namespace Src\Application\Exception;

use Psr\Container\ContainerExceptionInterface;

class ContainerException extends \Exception implements ContainerExceptionInterface
{

}