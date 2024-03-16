<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\InvalidDateValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonPayloadValidator\Exception\StringIsNotAnUrlException;
use Utils\JsonPayloadValidator\Exception\ValueNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueStringNotExactLengthException;
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
     * @throws ValueNotAStringException
     * @throws ValueStringTooSmallException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function minimumLength(string $key, array $payload, int $minimumLength): self;

    /**
     * @throws StringIsNotAnUrlException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function urlFormat(string $key, array $payload): self;

    /**
     * @throws ValueStringNotExactLengthException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function exactLength(string $key, array $payload, int $exactLength): self;

    /**
     * @throws InvalidDateValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function dateTimeFormat(string $key, array $payload, string $dateFormat): self;
}
