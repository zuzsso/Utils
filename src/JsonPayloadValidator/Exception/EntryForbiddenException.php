<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class EntryForbiddenException extends AbstractMalformedRequestBody
{
    public static function constructForKeyNameForbidden(string $key): self
    {
        return new self("Entry '$key' should not be present in the payload");
    }

    public function errorCode(): string
    {
        return 'propertyForbidden';
    }
}
