<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueTooSmallException extends AbstractMalformedRequestBody
{
    public static function constructForStringMessage(string $key, int $minimumLength, int $actualLength): self
    {
        return new self(
            "Entry '$key' is expected to be at least $minimumLength bytes long, but it is $actualLength"
        );
    }

    public static function constructForInteger(string $key, int $compareTo, int $value): self
    {
        return new self("Entry '$key' is meant to be equals or greater than '$compareTo': '$value'");
    }

    public static function constructForStandardFloatMessage(string $key, float $compareTo, float $value): self
    {
        return new self("Entry '$key' is meant to be equals or greater than '$compareTo': '$value'");
    }

    public function errorCode(): string
    {
        return 'expectedMinValue';
    }
}
