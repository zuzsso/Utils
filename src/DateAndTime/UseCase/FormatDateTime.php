<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;

/**
 * @deprecated
 * Migrated to its own repo
 */
interface FormatDateTime
{
    /**
     * @deprecated
     * Migrated to its own repo
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function fromMySqlDateTimeToImmutable(string $mysqlDateTime): DateTimeImmutable;

    /**
     * @deprecated
     * Migrated to its own repo
     */
    public function fromImmutableToMySqlDateTime(DateTimeImmutable $d): string;
}
