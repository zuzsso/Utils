<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateInterval;
use DateTimeImmutable;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;
use Utils\DateAndTime\UseCase\TransformDateTime;

/**
 * @deprecated
 * Migrated to its own repo
 */
class DateTimeTransformer implements TransformDateTime
{
    /**
     * @deprecated
     * Migrated to its own repo
     */
    public function removeTime(DateTimeImmutable $dateTimeImmutable): DateTimeImmutable
    {
        return $dateTimeImmutable->modify('midnight');
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @inheritDoc
     */
    public function substractDays(DateTimeImmutable $d, int $days): DateTimeImmutable
    {
        $this->checkStrictlyPositive($days);

        return $d->sub(new DateInterval("P${days}D"));
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @inheritDoc
     */
    public function substractSeconds(DateTimeImmutable $d, int $seconds): DateTimeImmutable
    {
        $this->checkStrictlyPositive($seconds);

        return $d->sub(new DateInterval("PT${seconds}S"));
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @inheritDoc
     */
    public function addSeconds(DateTimeImmutable $d, int $seconds): DateTimeImmutable
    {
        $this->checkStrictlyPositive($seconds);

        return $d->add(new DateInterval("PT${seconds}S"));
    }

    /**
     * @deprecated
     * Migrated to its own repo
     * @inheritDoc
     */
    public function addDays(DateTimeImmutable $d, int $days): DateTimeImmutable
    {
        $this->checkStrictlyPositive($days);

        return $d->add(new DateInterval("P${days}D"));
    }

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     * @deprecated
     * Migrated to its own repo
     */
    private function checkStrictlyPositive(int $value): void
    {
        if ($value <= 0) {
            throw new DatetimeCommonOperationsUnmanagedException(
                "This function requires a positive number of days and greater than 0 to substract. Provided: $value"
            );
        }
    }
}
