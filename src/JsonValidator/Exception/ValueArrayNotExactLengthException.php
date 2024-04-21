<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

class ValueArrayNotExactLengthException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForKeyArray(string $key, int $expectedLength, int $actualLength): self
    {
        return new self(
            "The key '$key' is expected to be an array of exact length of $expectedLength, but it is $actualLength"
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForValueArray(int $expectedLength, int $actualLength): self
    {
        return new self(
            "Value is expected to be an array of exact length of $expectedLength, but it is $actualLength"
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'arrayOfUnexpectedFixedLength';
    }
}
