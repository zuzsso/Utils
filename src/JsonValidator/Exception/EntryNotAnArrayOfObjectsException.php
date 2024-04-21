<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class EntryNotAnArrayOfObjectsException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(string $originalKey, string $subKey): self
    {
        return new self(
            "Entry '%originalKey%' should be an array of JSON objects, but item index '%subKey%' is not a JSON object",
            [
                'originalKey' => $originalKey,
                'subKey' => $subKey
            ]
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForIndexNotNumericArrayIndex(string $key, string $index): self
    {
        return new self(
            "Entry '%key%' is an array but it contains not numeric indexes: '%index%'",
            [
                'key' => $key,
                'index' => $index
            ]
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForCustomNumeration(string $key): self
    {
        return new self(
            "Entry '%key%' is an array but the first index is not 0 or the last index is not equals to the array count minus one",
            [
                'key' => $key
            ]
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return "notAnArrayOfJsonObjects";
    }
}
