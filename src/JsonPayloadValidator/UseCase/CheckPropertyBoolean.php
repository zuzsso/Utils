<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\InvalidBoolValueException;

interface CheckPropertyBoolean
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
