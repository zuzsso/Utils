<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use DateTimeImmutable;
use Utils\JsonValidator\Exception\IntegerComponentsDontRepresentDate;
use Utils\JsonValidator\UseCase\CheckValueInteger;

class ValueIntegerChecker implements CheckValueInteger
{
    /**
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
}
