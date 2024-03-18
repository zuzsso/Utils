<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class InvalidBoolValueException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self(
            "The entry '$key' does not hold a valid boolean value"
        );
    }
}
