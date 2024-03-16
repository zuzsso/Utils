<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotGreaterThanException extends AbstractMalformedRequestBody
{
    private const STANDARD_MESSAGE = "Entry '%key%' is meant to be greater than '%compareTo%': '%value%'";

    public static function constructForStandardIntegerMessage(string $key, int $compareTo, int $value): self
    {
        return new self(
            self::STANDARD_MESSAGE,
            [
                'key' => $key,
                'compareTo' => $compareTo,
                'value' => $value
            ]
        );
    }

    public static function constructForStandardFloatMessage(string $key, float $compareTo, float $value): self
    {
        return new self(
            self::STANDARD_MESSAGE,
            [
                'key' => $key,
                'compareTo' => $compareTo,
                'value' => $value
            ]
        );
    }

    public function errorCode(): string
    {
        return 'expectedMaxValue';
    }
}
