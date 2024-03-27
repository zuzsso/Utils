<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\IntegerComponentsDontRepresentDate;

interface CheckValueInteger
{
    /**
     * @throws IntegerComponentsDontRepresentDate
     */
    public function integerGroupRepresentsADate(int $year, int $month, int $day): void;
}
