<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueStringNotExactLengthException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, int $expectedLength, int $actualLength): self
    {
        return new self(
            "Entry %key% is expected to be %expectedLength% long, but it is %actualLength%",
            [
                'key' => $key,
                'expectedLength' => $expectedLength,
                'actualLength' => $actualLength
            ]
        );
    }

    public function errorCode(): string
    {
        return 'expectedStringOfExactLength';
    }
}
