<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class OptionalValueNotAStringException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(): self
    {
        return new self("The value is optional, but if provided it has to be a non empty string");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'optionalValueNotString';
    }
}
