<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

class ValueStringNotExactLengthException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, int $expectedLength, int $actualLength): self
    {
        return new self(
            "Entry '$key' is expected to be $expectedLength bytes long, but it is $actualLength"
        );
    }

    public function errorCode(): string
    {
        return 'expectedStringOfExactLength';
    }
}
