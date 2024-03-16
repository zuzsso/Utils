<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\ArrayDoesNotHaveMinimumElementCountException;
use Utils\JsonPayloadValidator\Exception\ArrayExceedsMaximumnAllowedNumberOfElementsException;
use Utils\JsonPayloadValidator\Exception\ArrayWithCustomIndexNumeration;
use Utils\JsonPayloadValidator\Exception\AssociatedValueToArrayKeyNotJsonObjectException;
use Utils\JsonPayloadValidator\Exception\NotNumericArrayIndexException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;

interface CheckPropertyArray
{
    /**
     * @throws ValueNotAnArrayException
     */
    public function requiredArray(string $key, array $payload): self;

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
    public function requiredArrayOfLength(
        string $key,
        array $payload,
        ?int $minCountIncluding,
        ?int $maxCountIncluding
    ): self;

    /**
     * @throws ArrayWithCustomIndexNumeration
     * @throws AssociatedValueToArrayKeyNotJsonObjectException
     * @throws NotNumericArrayIndexException
     */
    public function arrayOfJsonObjects(array $arrayElements): self;
}
