<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\InvalidIntegerValueException;
use Utils\JsonValidator\Exception\ValueNotEqualsToException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\AbstractIntegerRange;
use Utils\JsonValidator\Types\Range\IntValueRange;

interface CheckKeyInteger
{
    /**
     * @throws InvalidIntegerValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidIntegerValueException
     */
    public function optional(string $key, array $payload): self;

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws InvalidIntegerValueException
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function withinRange(
        string $key,
        array $payload,
        IntValueRange $range,
        bool $required = true
    ): self;

    /**
     * @throws InvalidIntegerValueException
     * @throws ValueNotEqualsToException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function equalsTo(string $key, array $payload, int $compareTo): self;
}
