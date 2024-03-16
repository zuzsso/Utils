<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotAStringException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self("The entry '$key' is not a string");
    }

    public function errorCode(): string
    {
        return 'expectedStringValue';
    }
}
