<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

class ValueStringEmptyException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(): self
    {
        return new self("Expected a string, but got null or empty string");
    }
}
