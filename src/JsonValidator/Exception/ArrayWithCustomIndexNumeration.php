<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ArrayWithCustomIndexNumeration extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForCustomNumeration(): self
    {
        return new self(
            "The array first index is not 0 or the last index is not equals to the array count minus one",
            []
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'arrayCustomNumeration';
    }
}
