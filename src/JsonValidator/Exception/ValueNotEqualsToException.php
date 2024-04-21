<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ValueNotEqualsToException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForInteger(string $key, int $compareTo, int $value): self
    {
        return new self("Entry '$key' is meant to be '$compareTo', but is '$value'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForFloat(string $key, float $compareTo, float $value): self
    {
        return new self("Entry '$key' is meant to be '$compareTo', but is '$value'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'unexpectedValue';
    }
}
