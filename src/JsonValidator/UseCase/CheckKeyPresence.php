<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\EntryMissingException;

interface CheckKeyPresence
{
    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @throws EntryForbiddenException
     */
    public function forbidden(string $key, array $payload): self;
}
