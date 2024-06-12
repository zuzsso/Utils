<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;
use Utils\Language\Type\Language\AbstractLanguage;

/**
 * @deprecated
 * Migrated to its own repo
 */
interface SerializeDateTime
{
    /**
     * @deprecated
     * @see \Utils\DateAndTime\UseCase\SerializeDateTime::serializeImmutableForLanguage
     */
    public function serializeImmutable(DateTimeImmutable $dateTime): array;

    /**
     * @deprecated
     * Migrated to its own repo
     */
    public function serializeImmutableForLanguage(DateTimeImmutable $dateTime, AbstractLanguage $lan): array;
}
