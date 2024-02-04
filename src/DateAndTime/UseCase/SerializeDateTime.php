<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;
use Utils\Language\Type\Language\AbstractLanguage;

interface SerializeDateTime
{
    /**
     * @deprecated
     * @see \Utils\DateAndTime\UseCase\SerializeDateTime::serializeImmutableForLanguage
     */
    public function serializeImmutable(DateTimeImmutable $dateTime): array;

    public function serializeImmutableForLanguage(DateTimeImmutable $dateTime, AbstractLanguage $lan): array;
}
