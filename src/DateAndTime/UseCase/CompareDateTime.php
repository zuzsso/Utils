<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;

/**
 * @deprecated
 * Migrated to its own repo
 */
interface CompareDateTime
{
    /**
     * Returns the difference in seconds between two dates, as in $d2 - $d1.
     *
     * Pass $absolute = true to get the difference in absolute terms. Otherwise, it will return a positive result
     * if $d1 < $d2. Negative otherwise.
     *
     * @deprecated
     * Migrated to its own repo
     */
    public function getDifferenceInSeconds(DateTimeImmutable $d1, DateTimeImmutable $d2, bool $absolute = false): int;
}
