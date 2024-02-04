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

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function substractSeconds(DateTimeImmutable $d, int $seconds): DateTimeImmutable;

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function addDays(DateTimeImmutable $d, int $days): DateTimeImmutable;

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function addSeconds(DateTimeImmutable $d, int $seconds): DateTimeImmutable;
}
