<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;

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
     */
    public function arrayOfLengthRange(
        array $payload,
        ?int $minLength,
        ?int $maxLength
    ): self;

    /**
     * @throws IncorrectParametrizationException
     * @throws ValueArrayNotExactLengthException
     */
    public function arrayOfExactLength(array $payload, int $expectedLength): self;
}
