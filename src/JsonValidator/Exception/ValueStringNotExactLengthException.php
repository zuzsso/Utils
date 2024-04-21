<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ValueStringNotExactLengthException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(string $key, int $expectedLength, int $actualLength): self
    {
        return new self(
            "Entry '$key' is expected to be $expectedLength bytes long, but it is $actualLength"
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'expectedStringOfExactLength';
    }
}
