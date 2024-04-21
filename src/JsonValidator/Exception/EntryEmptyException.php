<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;
/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class EntryEmptyException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForKeyNameEmpty(string $key): self
    {
        return new self("Entry '$key' empty");
    }
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'requiredValueForProperty';
    }
}
