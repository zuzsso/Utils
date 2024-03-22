<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\InvalidBoolValueException;

interface CheckKeyBoolean
{
    /**
     * @throws InvalidBoolValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @throws InvalidBoolValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function optional(string $key, array $payload): self;
}
