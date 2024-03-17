<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

/**
 * @deprecated
 * @see ValueTooBigException
 * @see ValueTooSmallException
 */
class ValueNotSmallerThanException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessageInteger(string $key, int $compareTo, int $value): self
    {
        return new self("Entry '$key' is meant to be less than '$compareTo': '$value'");
    }

    public static function constructForStandardMessageFloat(string $key, float $compareTo, float $value): self
    {
        return new self("Entry '$key' is meant to be less than '$compareTo': '$value'");
    }

    public function errorCode(): string
    {
        return 'expectedMinValue';
    }
}
