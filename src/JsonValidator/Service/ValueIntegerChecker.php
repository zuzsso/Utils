<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use DateTimeImmutable;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\IntegerComponentsDontRepresentDate;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\IntValueRange;
use Utils\JsonValidator\UseCase\CheckValueInteger;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ValueIntegerChecker implements CheckValueInteger
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function integerGroupRepresentsADate(int $year, int $month, int $day): void
    {
        $formattedYear = str_pad($year . '', 4, '0', STR_PAD_LEFT);
        $formattedMonth = str_pad($month . '', 2, '0', STR_PAD_LEFT);
        $formattedDay = str_pad($day . '', 2, '0', STR_PAD_LEFT);

        $tryDate = $formattedYear . '-' . $formattedMonth . '-' . $formattedDay;

        $success = DateTimeImmutable::createFromFormat('Y-m-d', $tryDate);

        $e = IntegerComponentsDontRepresentDate::constructForStandardMessage($year, $month, $day);

        if (!$success) {
            throw $e;
        }

        $converted = $success->format('Y-m-d');

        if ($converted !== $tryDate) {
            throw $e;
        }
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function withinRange(
        int $value,
        IntValueRange $range
    ): self {
        $minValue = $range->getMin();
        $maxValue = $range->getMax();

        if (($minValue !== null) && ($value < $minValue)) {
            throw ValueTooSmallException::constructForValueInteger($minValue, $value);
        }

        if (($maxValue !== null) && ($value > $maxValue)) {
            throw ValueTooBigException::constructForValueInteger($maxValue, $value);
        }

        return $this;
    }

}
