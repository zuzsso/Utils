<?php

declare(strict_types=1);

namespace Utils\DateAndTime\UseCase;

use DateTimeImmutable;

interface SerializeDateTime {
    public function serializeImmutable(DateTimeImmutable $dateTime): array;
}
