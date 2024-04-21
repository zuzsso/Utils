<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\JsonPayloadValidatorUnmanagedException;
use Utils\JsonValidator\Exception\ValueNotInListException;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckKeyEnum
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueNotInListException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws JsonPayloadValidatorUnmanagedException
     */
    public function isEnum(string $key, array $payload, array $validValues, bool $required = true): self;
}
