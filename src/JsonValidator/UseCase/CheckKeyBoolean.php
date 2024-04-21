<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\InvalidBoolValueException;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckKeyBoolean
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws InvalidBoolValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws InvalidBoolValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function optional(string $key, array $payload): self;
}
