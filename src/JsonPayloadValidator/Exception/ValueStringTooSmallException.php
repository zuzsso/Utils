<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueStringTooSmallException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, int $minimumLength, int $actualLength): self
    {
        return new self(
            "Entry '$key' is expected to be at least $minimumLength bytes long, but it is $actualLength"
        );
    }

    public function errorCode(): string
    {
        return 'expectedMinStringLength';
    }
}
