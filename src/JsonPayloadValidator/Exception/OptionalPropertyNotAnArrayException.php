<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

use Exception;

class OptionalPropertyNotAnArrayException extends Exception
{
    public static function constructForKey(string $key): self
    {
        return new self("Optional value is meant to be an array");
    }
}
