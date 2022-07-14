<?php

declare(strict_types=1);


namespace Utils\DateAndTime\Service;

use DateTimeImmutable;
use Utils\DateAndTime\UseCase\ProvideDateTime;

class DateTimeProvider implements ProvideDateTime {
    public function getSystemTime(): DateTimeImmutable {
        return new DateTimeImmutable('now');
    }
}
