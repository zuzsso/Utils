<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\ValueNotInListException;

interface CheckKeyCommon
{
    /**
     * @throws ValueNotInListException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function isEnum(string $key, array $payload, array $validValues, bool $required = true): self;
}
