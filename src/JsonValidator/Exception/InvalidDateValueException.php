<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class InvalidDateValueException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(string $key, string $format, string $value): self
    {
        return new self("Entry '$key' does not hold a valid '$format' date: '$value'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForValue(string $format, string $value): self
    {
        return new self("String not in format '$format' date: '$value'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'invalidDateFormat';
    }
}
