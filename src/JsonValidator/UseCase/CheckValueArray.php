<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonValidator\Exception\ValueNotAnArrayException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\ArrayLengthRange;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckValueArray
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     */
    public function arrayOfJsonObjects(array $arrayElements, bool $required = true): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     * @throws IncorrectParametrizationException
     * @throws ValueNotAnArrayException
     */
    public function arrayOfLengthRange(
        array $payload,
        ArrayLengthRange $lengthRange
    ): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws IncorrectParametrizationException
     * @throws ValueArrayNotExactLengthException
     * @throws ValueNotAnArrayException
     */
    public function arrayOfExactLength(array $payload, int $expectedLength): self;
}
