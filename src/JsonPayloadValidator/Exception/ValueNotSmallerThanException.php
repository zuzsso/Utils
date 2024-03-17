<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotSmallerThanException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, int $compareTo, int $value): self
    {
        return new self("Entry '$key' is meant to be less than '$compareTo': '$value'");
    }

    public function errorCode(): string
    {
        return 'expectedMinValue';
    }
}
