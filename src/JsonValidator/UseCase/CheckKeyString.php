<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\InvalidDateValueException;
use Utils\JsonValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonValidator\Exception\StringIsNotAnUrlException;
use Utils\JsonValidator\Exception\ValueNotAStringException;
use Utils\JsonValidator\Exception\ValueStringNotExactLengthException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\StringByteLengthRange;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckKeyString
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueNotAStringException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws OptionalPropertyNotAStringException
     */
    public function optional(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws ValueNotAStringException
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function byteLengthRange(
        string $key,
        array $payload,
        StringByteLengthRange $byteLengthRange,
        bool $required = true
    ): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws StringIsNotAnUrlException
     * @throws ValueNotAStringException
     */
    public function urlFormat(string $key, array $payload): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws IncorrectParametrizationException
     * @throws ValueStringNotExactLengthException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAStringException
     */
    public function exactByteLength(string $key, array $payload, int $exactLength): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidDateValueException
     * @throws ValueNotAStringException
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat): self;
}
