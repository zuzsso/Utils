<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class OptionalPropertyNotAStringException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(string $key): self
    {
        return new self("The entry '$key' is optional, but if provided it should be a string");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'entryOptionalNotString';
    }
}
