<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;


use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnEnumException;
use Utils\JsonPayloadValidator\Exception\ValueNotInListException;

interface CheckPropertyCommon
{
    /**
     * @throws ValueNotInListException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function isEnum(string $key, array $payload, array $validValues): self;

    /**
     * @throws OptionalPropertyNotAnEnumException
     */
    public function optionalEnum(string $key, array $payload, array $validValues): self;
}
