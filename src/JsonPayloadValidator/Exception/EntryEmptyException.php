<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class EntryEmptyException extends AbstractMalformedRequestBody
{
    public static function constructForKeyNameEmpty(string $key): self
    {
        return new self(
            "Entry %key% empty",
            ['key' => $key]
        );
    }

    public function errorCode(): string
    {
        return 'requiredValueForProperty';
    }
}
