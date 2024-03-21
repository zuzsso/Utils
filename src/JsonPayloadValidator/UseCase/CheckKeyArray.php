<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;

interface CheckKeyArray
{
    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     * @throws RequiredArrayIsEmptyException
     */
    public function requiredKey(string $key, array $payload): self;

    /**
     * @throws OptionalPropertyNotAnArrayException
     * @throws ValueNotAnArrayException
     */
    public function optionalKey(string $key, array $payload): self;

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     */
    public function keyArrayOfJsonObjects(string $key, array $payload, bool $required = true): self;


    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAnArrayException
     * @throws IncorrectParametrizationException
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function keyArrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minLength,
        ?int $maxLength,
        bool $required = true
    ): self;

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws RequiredArrayIsEmptyException
     * @throws ValueArrayNotExactLengthException
     * @throws ValueNotAnArrayException
     */
    public function keyArrayOfExactLength(string $key, array $payload, int $length, bool $required = true): self;
}
