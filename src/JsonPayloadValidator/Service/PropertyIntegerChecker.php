<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\InvalidIntegerValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnIntegerException;
use Utils\JsonPayloadValidator\Exception\ValueNotEqualsToException;
use Utils\JsonPayloadValidator\Exception\ValueNotGreaterThanException;
use Utils\JsonPayloadValidator\Exception\ValueNotSmallerThanException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyInteger;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;

class PropertyIntegerChecker implements CheckPropertyInteger
{
    private CheckPropertyPresence $checkPropertyPresence;

    public function __construct(CheckPropertyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $originalValue = $payload[$key];

        if (is_array($originalValue)) {
            throw InvalidIntegerValueException::constructForStandardMessage($key);
        }

        if (is_bool($originalValue)) {
            throw InvalidIntegerValueException::constructForStandardMessage($key);
        }

        if (is_string($originalValue)) {
            throw InvalidIntegerValueException::constructForStandardMessage($key);
        }

        $parsed = (int)$originalValue;

        if ((string)$parsed !== (string)$originalValue) {
            throw InvalidIntegerValueException::constructForStandardMessage($key);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optional(string $key, array $payload): CheckPropertyInteger
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
        } catch (EntryForbiddenException $e) {
            // Property present, so, make it sure it is an integer
            try {
                $this->required($key, $payload);
            } catch (EntryEmptyException | EntryMissingException $e) {
                // Not an integer
                throw OptionalPropertyNotAnIntegerException::constructForStandardMessage($key);
            }
        }

        return $this;
    }

    /**
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws InvalidIntegerValueException
     * @throws ValueNotGreaterThanException
     * @throws ValueNotSmallerThanException
     */
    public function withinRange(
        string $key,
        array $payload,
        ?int $minValue,
        ?int $maxValue,
        bool $required = true
    ): self {
        if (($minValue !== null) && ($maxValue !== null) && ($minValue >= $maxValue)) {
            throw new IncorrectParametrizationException("Min value cannot be greater or equal than max value");
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->required($key, $payload);

        $value = (int)$payload[$key];

        if (($minValue !== null) && ($value < $minValue)) {
            throw  ValueNotSmallerThanException::constructForStandardMessage($key, $minValue, $value);
        }

        if (($maxValue !== null) && ($value > $maxValue)) {
            throw ValueNotGreaterThanException::constructForStandardIntegerMessage($key, $maxValue, $value);
        }

        return $this;
    }

//    /**
//     * @inheritDoc
//     */
//    public function lessThan(string $key, array $payload, int $compareTo): self
//    {
//        $this->checkPropertyPresence->required($key, $payload);
//        $this->required($key, $payload);
//        $value = (int)$payload[$key];
//
//        if (!($value < $compareTo)) {
//            throw  ValueNotSmallerThanException::constructForStandardMessage($key, $compareTo, $value);
//        }
//
//        return $this;
//    }

    /**
     * @inheritDoc
     */
    public function equalsTo(string $key, array $payload, int $compareTo): self
    {
        $this->checkPropertyPresence->required($key, $payload);
        $this->required($key, $payload);

        $value = (int)$payload[$key];

        if ($value !== $compareTo) {
            throw ValueNotEqualsToException::constructForStandardMessage($key, $compareTo, $value);
        }

        return $this;
    }
}
