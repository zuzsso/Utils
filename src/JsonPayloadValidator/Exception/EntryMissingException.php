<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class EntryMissingException extends AbstractMalformedRequestBody
{
    public static function constructForKeyNameMissing(string $key): self
    {
        return new self("Entry '$key' missing");
    }

    public function errorCode(): string
    {
        return 'propertyRequired';
    }
}
