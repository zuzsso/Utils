<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotEqualsToException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessageInteger(string $key, int $compareTo, int $value): self
    {
        return new self("Entry '$key' is meant to be '$compareTo', but is '$value'");
    }

    public function errorCode(): string
    {
        return 'unexpectedValue';
    }
}
