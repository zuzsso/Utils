<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotAnArrayException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key): self
    {
        return new self(
            "Entry '%key%' is expected to be an array, but it doesn't exist",
            ['key' => $key]
        );
    }

    public function errorCode(): string
    {
        return 'expectedArrayValue';
    }
}
