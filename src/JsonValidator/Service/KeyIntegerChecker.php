<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\InvalidIntegerValueException;
use Utils\JsonValidator\Exception\ValueNotEqualsToException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\UseCase\CheckKeyInteger;
use Utils\JsonValidator\UseCase\CheckKeyPresence;

class KeyIntegerChecker extends AbstractJsonChecker implements CheckKeyInteger
{
    private CheckKeyPresence $checkPropertyPresence;

    public function __construct(CheckKeyPresence $checkPropertyPresence)
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
    public function optional(string $key, array $payload): CheckKeyInteger
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
        }

        $this->required($key, $payload);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function withinRange(
        string $key,
        array $payload,
        ?int $minValue,
        ?int $maxValue,
        bool $required = true
    ): self {

        if (($minValue === null) && ($maxValue === null)) {
            throw new IncorrectParametrizationException("No range defined");
        }
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
            throw ValueTooSmallException::constructForInteger($key, $minValue, $value);
        }

        if (($maxValue !== null) && ($value > $maxValue)) {
            throw ValueTooBigException::constructForInteger($key, $maxValue, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function equalsTo(string $key, array $payload, int $compareTo, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->checkPropertyPresence->required($key, $payload);
        $this->required($key, $payload);

        $value = (int)$payload[$key];

        if ($value !== $compareTo) {
            throw ValueNotEqualsToException::constructForInteger($key, $compareTo, $value);
        }

        return $this;
    }
}
