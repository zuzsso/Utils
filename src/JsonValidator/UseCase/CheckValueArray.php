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

interface CheckValueArray
{
    /**
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     */
    public function arrayOfJsonObjects(array $arrayElements, bool $required = true): self;

    /**
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
     * @throws IncorrectParametrizationException
     * @throws ValueArrayNotExactLengthException
     * @throws ValueNotAnArrayException
     */
    public function arrayOfExactLength(array $payload, int $expectedLength): self;
}
