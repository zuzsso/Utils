<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\JsonPayloadValidatorUnmanagedException;
use Utils\JsonPayloadValidator\Exception\ValueNotInListException;

interface CheckKeyEnum
{
    /**
     * @throws ValueNotInListException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws JsonPayloadValidatorUnmanagedException
     */
    public function isEnum(string $key, array $payload, array $validValues, bool $required = true): self;
}
