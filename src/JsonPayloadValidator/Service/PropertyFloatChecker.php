<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Throwable;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotEqualsToException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyFloat;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;
use Utils\Math\Numbers\UseCase\EqualFloats;

class PropertyFloatChecker implements CheckPropertyFloat
{
    private CheckPropertyPresence $checkPropertyPresence;
    private EqualFloats $equalFloats;

    public function __construct(CheckPropertyPresence $checkPropertyPresence, EqualFloats $equalFloats)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
        $this->equalFloats = $equalFloats;
    }

    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): CheckPropertyFloat
    {
        $this->checkPropertyPresence->required($key, $payload);

        $originalValue = $payload[$key];

        if (is_bool($originalValue)) {
            throw ValueNotAFloatException::constructForStandardMessage($key, (string)$originalValue);
        }

        if (is_string($originalValue)) {
            throw ValueNotAFloatException::constructForStringValue($key, $originalValue);
        }

        if (is_array($originalValue)) {
            throw ValueNotAFloatException::constructForGenericMessage($key);
        }

        $castValue = (float)$originalValue;

        if (((string)$castValue) !== ((string)$originalValue)) {
            throw ValueNotAFloatException::constructForStandardMessage($key, (string)$originalValue);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optional(string $key, array $payload): CheckPropertyFloat
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
        } catch (EntryForbiddenException $e) {
            // Property exists, so make sure it is a float
            try {
                $this->required($key, $payload);
            } catch (Throwable $t) {
                throw OptionalPropertyNotAFloatException::constructForStandardMessage($key);
            }
        }

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function withinRange(
        string $key,
        array $payload,
        ?float $minValue,
        ?float $maxValue,
        bool $required = true
    ): self {
        if (($minValue === null) && ($maxValue === null)) {
            throw new IncorrectParametrizationException(
                "No range defined. You may want to use the 'required' function"
            );
        }

        if (($minValue !== null) && ($maxValue !== null)) {
            $equals = $this->equalFloats->equalFloats($minValue, $maxValue);
            $greaterThan = $minValue > $maxValue;
            if ($equals || $greaterThan) {
                throw new IncorrectParametrizationException("Min value cannot be equal or greater than max value");
            }
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->required($key, $payload);

        $value = (float)$payload[$key];

        if ($minValue !== null) {
            $equals = $this->equalFloats->equalFloats($minValue, $value);
            if ((!$equals) && ($value < $minValue)) {
                throw ValueTooSmallException::constructForStandardFloatMessage($key, $minValue, $value);
            }
        }

        if ($maxValue !== null) {
            $equals = $this->equalFloats->equalFloats($maxValue, $value);
            if ((!$equals) && ($value > $maxValue)) {
                throw ValueTooBigException::constructForStandardFloatMessage($key, $maxValue, $value);
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function equalsTo(string $key, array $payload, float $compareTo, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->required($key, $payload);

        $value = (float)$payload[$key];

        $equals = $this->equalFloats->equalFloats($value, $compareTo);

        if (!$equals) {
            throw ValueNotEqualsToException::constructForFloat($key, $compareTo, $value);
        }

        return $this;
    }
}
