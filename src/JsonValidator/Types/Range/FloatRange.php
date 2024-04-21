<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Types\Range;

use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\Math\Numbers\UseCase\EqualFloats;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class FloatRange
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    private ?float $min;
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    private ?float $max;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws IncorrectParametrizationException
     */
    public function __construct(EqualFloats $equalFloats, ?float $min, ?float $max)
    {
        if (($min === null) && ($max === null)) {
            throw new IncorrectParametrizationException(
                "No range defined. You may want to use the 'required' function"
            );
        }

        if (($min !== null) && ($max !== null)) {
            $equals = $equalFloats->equalFloats($min, $max);
            $greaterThan = $min > $max;
            if ($equals || $greaterThan) {
                throw new IncorrectParametrizationException("Min value cannot be equal or greater than max value");
            }
        }

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getMin(): ?float
    {
        return $this->min;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getMax(): ?float
    {
        return $this->max;
    }
}
