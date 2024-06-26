<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\UseCase\CheckKeyPresence;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class KeyPresenceChecker extends AbstractJsonChecker implements CheckKeyPresence
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function required(string $key, array $payload): self
    {
        if (!array_key_exists($key, $payload)) {
            throw EntryMissingException::constructForKeyNameMissing($key);
        }

        $e = EntryEmptyException::constructForKeyNameEmpty($key);

        $v = $payload[$key];

        if (empty($v) && ($v !== '0') && ($v !== 0) && ($v !== false)) {
            throw $e;
        }

        if (is_string($v) && trim($v) === '') {
            throw $e;
        }

        return $this;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function forbidden(string $key, array $payload): self
    {
        if (array_key_exists($key, $payload) && ($payload[$key] !== null)) {
            throw EntryForbiddenException::constructForKeyNameForbidden($key);
        }

        return $this;
    }
}
