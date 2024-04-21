<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Throwable;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonValidator\Exception\ValueNotAFloatException;
use Utils\JsonValidator\Exception\ValueNotEqualsToException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\FloatRange;
use Utils\JsonValidator\UseCase\CheckKeyFloat;
use Utils\JsonValidator\UseCase\CheckKeyPresence;
use Utils\Math\Numbers\UseCase\EqualFloats;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class KeyFloatChecker extends AbstractJsonChecker implements CheckKeyFloat
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    private CheckKeyPresence $checkPropertyPresence;
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    private EqualFloats $equalFloats;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function __construct(CheckKeyPresence $checkPropertyPresence, EqualFloats $equalFloats)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
        $this->equalFloats = $equalFloats;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function required(string $key, array $payload): CheckKeyFloat
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
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function optional(string $key, array $payload): CheckKeyFloat
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
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function withinRange(
        string $key,
        array $payload,
        FloatRange $range,
        bool $required = true
    ): self {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->required($key, $payload);

        $value = (float)$payload[$key];

        $minValue = $range->getMin();
        $maxValue = $range->getMax();

        if ($minValue !== null) {
            $equals = $this->equalFloats->equalFloats($minValue, $value);
            if ((!$equals) && ($value < $minValue)) {
                throw ValueTooSmallException::constructForStandardFloat($key, $minValue, $value);
            }
        }

        if ($maxValue !== null) {
            $equals = $this->equalFloats->equalFloats($maxValue, $value);
            if ((!$equals) && ($value > $maxValue)) {
                throw ValueTooBigException::constructForFloat($key, $maxValue, $value);
            }
        }

        return $this;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
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
