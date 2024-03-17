<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Throwable;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotGreaterThanException;
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
        $this->required($key, $payload);

        $value = $payload[$key];

        if (!($value > $compareTo)) {
            throw ValueNotGreaterThanException::constructForStandardFloatMessage($key, $compareTo, $value);
        }

        return $this;
    }

    public function equalsTo(string $key, array $payload, float $compareTo, bool $required = true): CheckPropertyFloat
    {
        return $this;
    }



//    /**
//     * @inheritDoc
//     */
//    public function optionalGreaterThan(string $key, array $payload, float $compareTo): CheckPropertyFloat
//    {
//        $this->optional($key, $payload);
//
//        $value = $payload[$key] ?? null;
//
//        if ($value === null) {
//            return $this;
//        }
//
//        $castValue = (float)$value;
//
//        if (!($castValue > $compareTo)) {
//            throw ValueNotGreaterThanException::constructForStandardFloatMessage($key, $compareTo, $castValue);
//        }
//
//        return $this;
//    }
}
