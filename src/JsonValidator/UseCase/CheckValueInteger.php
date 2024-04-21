<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\IntegerComponentsDontRepresentDate;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\IntValueRange;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckValueInteger
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws IntegerComponentsDontRepresentDate
     */
    public function integerGroupRepresentsADate(int $year, int $month, int $day): void;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function withinRange(
        int $value,
        IntValueRange $range
    ): self;
}
