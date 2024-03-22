<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Types\Range;

use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\Math\Numbers\UseCase\EqualFloats;

class FloatRange
{
    private ?float $min;
    private ?float $max;

    /**
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

    public function getMin(): ?float
    {
        return $this->min;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }
}
