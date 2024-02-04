<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;

interface ImplementDateTimeCommonOperations
{
    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function fromMySqlDateTimeToImmutable(string $mysqlDateTime): DateTimeImmutable;

    public function fromImmutableToMySqlDateTime(DateTimeImmutable $d): string;
}
