<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class OptionalPropertyNotAnEnumException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForList(string $key, array $listOfValidValues, string $givenValue): self
    {
        return new self(
            "The key '%key%' is optional, but if given has to be one of the following: [%values%]. Given: '%givenValue%'",
            [
                'key' => $key,
                'givenValue' => $givenValue,
                'values' => implode(' | ', $listOfValidValues)
            ]
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'unexpectedOptionalEnumValue';
    }
}
