<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Types\Range;

use Utils\JsonValidator\Exception\IncorrectParametrizationException;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
abstract class AbstractIntegerRange
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    protected ?int $min;
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    protected ?int $max;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws IncorrectParametrizationException
     */
    public function __construct(?int $min, ?int $max)
    {
        if (($min === null) && ($max === null)) {
            throw new IncorrectParametrizationException('No range given');
        }

        if (($min !== null) && ($max !== null) && ($min >= $max)) {
            throw new IncorrectParametrizationException(
                'Range not correctly defined. min should be < than max, strictly'
            );
        }

        $this->min = $min;
        $this->max = $max;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getMin(): ?int
    {
        return $this->min;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getMax(): ?int
    {
        return $this->max;
    }
}
