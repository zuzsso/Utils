<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateTimeImmutable;
use Utils\DateAndTime\UseCase\SerializeDateTime;

class DateTimeSerializer implements SerializeDateTime {
    public function serializeImmutable(DateTimeImmutable $dateTime): array {
        return [
            'components' => [
                'day' => (int)$dateTime->format('d'),
                'month' => (int)$dateTime->format('m'),
                'year' => (int)$dateTime->format('Y'),
                'hour' => (int)$dateTime->format('H'),
                'minute' => (int)$dateTime->format('m'),
                'second' => (int)$dateTime->format('s')
            ],
            'formatted' => [
                'longDate' => [
                    'spanish' => $dateTime->format('j \d\e F, Y'),
                    'english' => $dateTime->format('F jS, Y'),
                    'french' => $dateTime->format('F j, Y'),
                ]
            ]
        ];
    }
}
