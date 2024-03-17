<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotAFloatException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, string $value): self
    {
        return new self("The entry '$key' is required to be a float type, but could not be parsed as such: '$value'");
    }

    public static function constructForStringValue(string $key, string $value): self
    {
        return new self("The entry '$key' is required to be a float type, but got an string: '$value'");
    }

    public static function constructForGenericMessage(string $key): self
    {
        return new self("The entry '$key' is required to be a float type");
    }

    public function errorCode(): string
    {
        return 'expectedFloatValue';
    }
}
