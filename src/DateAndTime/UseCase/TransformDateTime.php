<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;

/**
 * @deprecated
 * Migrated to its own repo
 */
interface TransformDateTime
{
    /**
     * @deprecated
     * Migrated to its own repo
     */
    public function removeTime(DateTimeImmutable $dateTimeImmutable): DateTimeImmutable;

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function substractDays(DateTimeImmutable $d, int $days): DateTimeImmutable;

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function substractSeconds(DateTimeImmutable $d, int $seconds): DateTimeImmutable;

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function addDays(DateTimeImmutable $d, int $days): DateTimeImmutable;

    /**
     * @deprecated
     * Migrated to its own repo
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function addSeconds(DateTimeImmutable $d, int $seconds): DateTimeImmutable;
}
