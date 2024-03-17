<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class InvalidIntegerValueException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self("Entry '$key' does not hold a valid int value");
    }

    public function errorCode(): string
    {
        return 'requiredIntegerValue';
    }
}
