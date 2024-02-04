<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateInterval;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;
use Utils\DateAndTime\UseCase\ImplementDateTimeCommonOperations;
use DateTimeImmutable;

class DateTimeCommonOperationsImplementer implements ImplementDateTimeCommonOperations
{
    private const MYSQL_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @inheritDoc
     */
    public function fromMySqlDateTimeToImmutable(string $mysqlDateTime): DateTimeImmutable
    {
        $result = DateTimeImmutable::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $mysqlDateTime);

        if ($result === false) {
            throw new DatetimeCommonOperationsUnmanagedException(
                "Could not convert literal '$mysqlDateTime' to Date time format " . self::MYSQL_DATE_TIME_FORMAT
            );
        }

        return $result;
    }

    public function fromImmutableToMySqlDateTime(DateTimeImmutable $d): string
    {
        return $d->format(self::MYSQL_DATE_TIME_FORMAT);
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
