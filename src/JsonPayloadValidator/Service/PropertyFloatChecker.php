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

class PropertyFloatChecker implements CheckPropertyFloat
{
    private CheckPropertyPresence $checkPropertyPresence;

    public function __construct(CheckPropertyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): CheckPropertyFloat
    {
        $this->checkPropertyPresence->required($key, $payload);

        $originalValue = $payload[$key];

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
    public function greaterThan(string $key, array $payload, float $compareTo): CheckPropertyFloat
    {
        $this->required($key, $payload);

        $value = $payload[$key];

        if (!($value > $compareTo)) {
            throw ValueNotGreaterThanException::constructForStandardFloatMessage($key, $compareTo, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optionalGreaterThan(string $key, array $payload, float $compareTo): CheckPropertyFloat
    {
        $this->optional($key, $payload);

        $value = $payload[$key] ?? null;

        if ($value === null) {
            return $this;
        }

        $castValue = (float)$value;

        if (!($castValue > $compareTo)) {
            throw ValueNotGreaterThanException::constructForStandardFloatMessage($key, $compareTo, $castValue);
        }

        return $this;
    }
}
