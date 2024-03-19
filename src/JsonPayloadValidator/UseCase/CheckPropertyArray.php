<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\ArrayDoesNotHaveMinimumElementCountException;
use Utils\JsonPayloadValidator\Exception\ArrayExceedsMaximumnAllowedNumberOfElementsException;
use Utils\JsonPayloadValidator\Exception\ArrayWithCustomIndexNumeration;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\NotNumericArrayIndexException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Service\PropertyArrayChecker;

interface CheckPropertyArray
{
    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     */
    public function requiredKey(string $key, array $payload): self;

    public function optionalKey(string $key, array $payload): self;

    /**
     * @throws ArrayWithCustomIndexNumeration
     * @throws ValueNotAJsonObjectException
     * @throws NotNumericArrayIndexException
     * @throws ValueNotAnArrayException
     */
    public function keyOfJsonObjects(string $key, array $payload, bool $required = true): self;

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
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     * @throws RequiredArrayIsEmptyException
     */
    public function arrayOfJsonObjects(array $arrayElements): self;
}
