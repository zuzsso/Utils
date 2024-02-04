<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;
use Utils\DateAndTime\UseCase\ImplementDateTimeCommonOperations;
use DateTimeImmutable;

class DateTimeCommonOperationsImplementer implements ImplementDateTimeCommonOperations
{
    private const MYSQL_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @inheritDoc
     */
    public function dateTimeImmutableFromMySql(string $mysqlDateTime): DateTimeImmutable
    {
        $result = DateTimeImmutable::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $mysqlDateTime);

        if ($result === false) {
            throw new DatetimeCommonOperationsUnmanagedException(
                "Could not convert literal '$mysqlDateTime' to Date time format " . self::MYSQL_DATE_TIME_FORMAT
            );
        }

        return $result;
    }
}
