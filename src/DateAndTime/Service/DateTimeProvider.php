<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateTimeImmutable;
use Utils\DateAndTime\UseCase\ProvideDateTime;

/**
 * @deprecated
 * Migrated to its own repo
 */
class DateTimeProvider implements ProvideDateTime
{
    /**
     * @deprecated
     * Migrated to its own repo
     */
    public function getSystemDateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}
