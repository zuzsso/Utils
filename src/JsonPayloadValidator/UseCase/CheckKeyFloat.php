<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotEqualsToException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\Service\KeyFloatChecker;

interface CheckKeyFloat
{
    /**
     * @throws ValueNotAFloatException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @throws OptionalPropertyNotAFloatException
     */
    public function optional(string $key, array $payload): self;

    /**
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
        ?float $minValue,
        ?float $maxValue,
        bool $required = true
    ): self;

    /**
     * @throws ValueNotAFloatException
     * @throws ValueNotEqualsToException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function equalsTo(string $key, array $payload, float $compareTo, bool $required = true): self;
}
