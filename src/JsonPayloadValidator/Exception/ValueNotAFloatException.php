<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotAFloatException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, string $value): self
    {
        return new self(
            "The entry '%key%' is required to be a float type, but could not be parsed as such: '%value%'",
            [
                'key' => $key,
                'value' => $value
            ]
        );
    }

    public function errorCode(): string
    {
        return 'expectedFloatValue';
    }
}
