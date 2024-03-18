<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\ArrayDoesNotHaveMinimumElementCountException;
use Utils\JsonPayloadValidator\Exception\ArrayExceedsMaximumnAllowedNumberOfElementsException;
use Utils\JsonPayloadValidator\Exception\ArrayWithCustomIndexNumeration;
use Utils\JsonPayloadValidator\Exception\AssociatedValueToArrayKeyNotJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\NotNumericArrayIndexException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;

interface CheckPropertyArray
{
    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     */
    public function required(string $key, array $payload): self;

    public function optional(string $key, array $payload): self;

    /**
     * @throws ArrayWithCustomIndexNumeration
     * @throws AssociatedValueToArrayKeyNotJsonObjectException
     * @throws NotNumericArrayIndexException
     * @throws ValueNotAnArrayException
     */
    public function requiredArrayOfJsonObjects(string $key, array $payload): self;

    /**
     * @throws ArrayDoesNotHaveMinimumElementCountException
     * @throws ArrayExceedsMaximumnAllowedNumberOfElementsException
     * @throws ValueNotAnArrayException
     */
    public function arrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minCount,
        ?int $maxCount,
        bool $required = true
    ): self;

    /**
     * @throws ArrayWithCustomIndexNumeration
     * @throws AssociatedValueToArrayKeyNotJsonObjectException
     * @throws NotNumericArrayIndexException
     */
    public function arrayOfJsonObjects(array $arrayElements): self;
}
