<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
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
     * @inheritDoc
     */
    public function greaterThan(string $key, array $payload, int $compareTo): self
    {
        $this->checkPropertyPresence->required($key, $payload);
        $this->required($key, $payload);

        $value = (int)$payload[$key];

        if (!($value > $compareTo)) {
            throw ValueNotGreaterThanException::constructForStandardIntegerMessage($key, $compareTo, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function lessThan(string $key, array $payload, int $compareTo): self
    {
        $this->checkPropertyPresence->required($key, $payload);
        $this->required($key, $payload);
        $value = (int)$payload[$key];

        if (!($value < $compareTo)) {
            throw  ValueNotSmallerThanException::constructForStandardMessage($key, $compareTo, $value);
        }

        return $this;
    }

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
