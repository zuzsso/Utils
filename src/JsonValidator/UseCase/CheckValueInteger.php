<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\IntegerComponentsDontRepresentDate;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\IntValueRange;

interface CheckValueInteger
{
    /**
     * @throws IntegerComponentsDontRepresentDate
     */
    public function integerGroupRepresentsADate(int $year, int $month, int $day): void;

    /**
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function withinRange(
        int $value,
        IntValueRange $range
    ): self;
}
