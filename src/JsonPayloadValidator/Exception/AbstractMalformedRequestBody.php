<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

use Exception;
use LogicException;
use Throwable;

abstract class AbstractMalformedRequestBody extends Exception
{
}
