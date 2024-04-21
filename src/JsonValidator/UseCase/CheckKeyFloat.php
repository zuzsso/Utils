<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonValidator\Exception\ValueNotAFloatException;
use Utils\JsonValidator\Exception\ValueNotEqualsToException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\FloatRange;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckKeyFloat
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueNotAFloatException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws OptionalPropertyNotAFloatException
     */
    public function optional(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws IncorrectParametrizationException
     * @throws ValueNotAFloatException
     * @throws ValueTooSmallException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueTooBigException
     */
    public function withinRange(
        string $key,
        array $payload,
        FloatRange $range,
        bool $required = true
    ): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueNotAFloatException
     * @throws ValueNotEqualsToException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function equalsTo(string $key, array $payload, float $compareTo, bool $required = true): self;
}
