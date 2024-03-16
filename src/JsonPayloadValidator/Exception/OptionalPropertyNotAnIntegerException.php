<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class OptionalPropertyNotAnIntegerException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self(
            "The entry '%key%' is optional, but if provided it should be an integer",
            ['key' => $key]
        );
    }

    public function errorCode(): string
    {
        return 'entryOptionalNotInteger';
    }
}
