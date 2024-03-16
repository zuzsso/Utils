<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueStringTooBigException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, int $maximumLength, int $actualLength): self
    {
        return new self(
            "Entry '$key' is expected to be $maximumLength bytes long maximum, but it is $actualLength"
        );
    }

    public function errorCode(): string
    {
        return 'expectedMaxStringLength';
    }
}
