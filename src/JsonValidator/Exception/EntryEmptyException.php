<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

class EntryEmptyException extends AbstractMalformedRequestBody
{
    public static function constructForKeyNameEmpty(string $key): self
    {
        return new self("Entry '$key' empty");
    }

    public function getErrorCode(): string
    {
        return 'requiredValueForProperty';
    }
}
