<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotInListException extends AbstractMalformedRequestBody
{
    public static function constructForList(string $key, array $listOfValidValues, string $givenValue): self
    {
        $vals = implode(' | ', $listOfValidValues);

        return new self("The key '$key' can only be one of the following: [$vals], but it is '$givenValue'");
    }

    public function errorCode(): string
    {
        return 'unexpectedEnumValue';
    }
}
