<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;

interface TransformDateTime
{
    public function removeTime(DateTimeImmutable $dateTimeImmutable): DateTimeImmutable;

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function substractDays(DateTimeImmutable $d, int $days): DateTimeImmutable;
}
