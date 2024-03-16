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
use Utils\JsonPayloadValidator\Exception\ValueStringTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueStringTooSmallException;

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
     * @throws ValueStringTooBigException
     * @throws ValueStringTooSmallException
     */
    public function byteLengthRange(
        string $key,
        array $payload,
        ?int $minimumLength,
        ?int $maximumLength,
        bool $required = true
    ): self;

    /**
     * @throws StringIsNotAnUrlException
     * @throws EntryEmptyException
     * @throws EntryMissingException
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
     * @throws InvalidDateValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat): self;
}
