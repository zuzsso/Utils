<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\UseCase\CheckKeyPresence;

class KeyPresenceChecker implements CheckKeyPresence
{
    /**
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
