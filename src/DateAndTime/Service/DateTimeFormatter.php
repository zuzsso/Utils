<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;
use Utils\DateAndTime\UseCase\FormatDateTime;
use DateTimeImmutable;

/**
 * @deprecated
 * Migrated to its own repo
 */
class DateTimeFormatter implements FormatDateTime
{
    private const MYSQL_DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @deprecated
     * Migrated to its own repo
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

    /**
     * @deprecated
     * Migrated to its own repo
     */
    public function fromImmutableToMySqlDateTime(DateTimeImmutable $d): string
    {
        return $d->format(self::MYSQL_DATE_TIME_FORMAT);
    }
}
