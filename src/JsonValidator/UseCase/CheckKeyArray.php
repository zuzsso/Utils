<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\OptionalPropertyNotAnArrayException;
use Utils\JsonValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonValidator\Exception\ValueNotAnArrayException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;

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
    public function keyArrayOfExactLength(string $key, array $payload, int $expectedLength, bool $required = true): self;
}
