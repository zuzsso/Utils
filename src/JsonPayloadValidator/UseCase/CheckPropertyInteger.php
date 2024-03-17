<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\InvalidIntegerValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnIntegerException;
use Utils\JsonPayloadValidator\Exception\ValueNotEqualsToException;
use Utils\JsonPayloadValidator\Exception\ValueNotGreaterThanException;
use Utils\JsonPayloadValidator\Exception\ValueNotSmallerThanException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;

interface CheckPropertyInteger
{
    /**
     * @throws InvalidIntegerValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @throws InvalidIntegerValueException
     * @throws OptionalPropertyNotAnIntegerException
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
        ?int $minValue,
        ?int $maxValue,
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
