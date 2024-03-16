<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class OptionalPropertyNotAStringException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self("The entry '$key' is optional, but if provided it should be a string");
    }

    public function errorCode(): string
    {
        return 'entryOptionalNotString';
    }
}
