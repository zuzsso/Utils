<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ValueNotAFloatException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(string $key, string $value): self
    {
        return new self("The entry '$key' is required to be a float type, but could not be parsed as such: '$value'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStringValue(string $key, string $value): self
    {
        return new self("The entry '$key' is required to be a float type, but got an string: '$value'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForGenericMessage(string $key): self
    {
        return new self("The entry '$key' is required to be a float type");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'expectedFloatValue';
    }
}
