<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

class OptionalPropertyNotAFloatException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self("The entry '$key' is optional, but if provided it should be a a float");
    }

    public function errorCode(): string
    {
        return 'entryOptionalNotFloat';
    }
}
