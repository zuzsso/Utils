<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueArrayNotExactLengthException extends AbstractMalformedRequestBody
{
    public static function constructForKeyArray(string $key, int $expectedLength, int $actualLength): self
    {
        return new self(
            "The key '$key' is expected to be an array of exact length of $expectedLength, but it is $actualLength"
        );
    }
}
