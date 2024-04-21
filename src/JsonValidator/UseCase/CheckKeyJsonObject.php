<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckKeyJsonObject
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function required(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function optional(string $key, array $payload): self;
}
