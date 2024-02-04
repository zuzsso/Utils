<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateInterval;
use DateTimeImmutable;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;
use Utils\DateAndTime\UseCase\TransformDateTime;

class DateTimeTransformer implements TransformDateTime
{
    public function removeTime(DateTimeImmutable $dateTimeImmutable): DateTimeImmutable
    {
        return $dateTimeImmutable->modify('midnight');
    }

    public function substractDays(DateTimeImmutable $d, int $days): DateTimeImmutable
    {
        if ($days <= 0) {
            throw new DatetimeCommonOperationsUnmanagedException(
                "This function requires a positive number of days and greater than 0 to substract. Provided: $days"
            );
        }

        return $d->sub(new DateInterval("P${days}D"));
    }
}
