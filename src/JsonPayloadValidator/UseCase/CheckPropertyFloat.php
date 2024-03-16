<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotGreaterThanException;

interface CheckPropertyFloat
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
     * @throws ValueNotAFloatException
     * @throws ValueNotGreaterThanException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function greaterThan(string $key, array $payload, float $compareTo): self;

    /**
     * @throws OptionalPropertyNotAFloatException
     * @throws ValueNotGreaterThanException
     */
    public function optionalGreaterThan(string $key, array $payload, float $compareTo): self;
}
