<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ValueNotInListException extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForList(string $key, array $listOfValidValues, string $givenValue): self
    {
        $vals = implode(' | ', $listOfValidValues);

        return new self("The key '$key' can only be one of the following: [$vals], but it is '$givenValue'");
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'unexpectedEnumValue';
    }
}
