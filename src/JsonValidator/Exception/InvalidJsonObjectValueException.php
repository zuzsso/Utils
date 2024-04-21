<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class InvalidJsonObjectValueException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForRequiredKey(string $key): self
    {
        return new self("The key '$key' is required and must point to a valid JSON object");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForOptionalValue(string $key): self
    {
        return new self("The key '$key' is optional, but if provided, it must be a valid JSON object");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'invalidJsonObject';
    }
}
