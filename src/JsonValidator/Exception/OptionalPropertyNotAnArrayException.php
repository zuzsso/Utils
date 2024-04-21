<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

use Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class OptionalPropertyNotAnArrayException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForKey(string $key): self
    {
        return new self("Optional value is meant to be an array");
    }
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'optionalValueNotAnArray';
    }
}
