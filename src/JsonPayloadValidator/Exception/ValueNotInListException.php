<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ValueNotInListException extends AbstractMalformedRequestBody
{
    public static function constructForList(string $key, array $listOfValidValues, string $givenValue): self
    {
        return new self(
            "The key '%key%' can only be one of the following: [%values%], but it is '%givenValue%'",
            [
                'key' => $key,
                'givenValue' => $givenValue,
                'values' => implode(' | ', $listOfValidValues)
            ]
        );
    }

    public function errorCode(): string
    {
        return 'unexpectedEnumValue';
    }
}
