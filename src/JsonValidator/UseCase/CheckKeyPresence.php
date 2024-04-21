<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\EntryMissingException;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckKeyPresence
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws EntryForbiddenException
     */
    public function forbidden(string $key, array $payload): self;
}
