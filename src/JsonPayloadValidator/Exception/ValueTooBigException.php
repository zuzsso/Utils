<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueTooBigException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, int $maximumLength, int $actualLength): self
    {
        return new self(
            "Entry '$key' is expected to be $maximumLength bytes long maximum, but it is $actualLength"
        );
    }

    public static function constructForInteger(string $key, int $compareTo, int $value): self
    {
        return new self("Entry '$key' is meant to be equals or less than '$compareTo': '$value'");
    }

    public static function constructForStandardFloatMessage(string $key, float $compareTo, float $value): self
    {
        return new self("Entry '$key' is meant to be equals or less than '$compareTo': '$value'");
    }

    public function errorCode(): string
    {
        return 'expectedMaxValue';
    }
}
