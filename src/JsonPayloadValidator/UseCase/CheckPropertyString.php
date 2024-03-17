<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\InvalidDateValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonPayloadValidator\Exception\StringIsNotAnUrlException;
use Utils\JsonPayloadValidator\Exception\ValueNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueStringNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\Service\PropertyStringChecker;

interface CheckPropertyString
{
    /**
     * @throws ValueNotAStringException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): self;

    /**
     * @throws OptionalPropertyNotAStringException
     */
    public function optional(string $key, array $payload): self;

    /**
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
        ?int $minimumLength,
        ?int $maximumLength,
        bool $required = true
    ): self;

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws StringIsNotAnUrlException
     * @throws ValueNotAStringException
     */
    public function urlFormat(string $key, array $payload): self;

    /**
     * @throws IncorrectParametrizationException
     * @throws ValueStringNotExactLengthException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAStringException
     */
    public function exactByteLength(string $key, array $payload, int $exactLength): self;

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidDateValueException
     * @throws ValueNotAStringException
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat): self;
}
