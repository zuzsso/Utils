<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateTimeImmutable;
use Utils\DateAndTime\UseCase\SerializeDateTime;

class DateTimeSerializer implements SerializeDateTime {
    private static array $longMonthNames = [
        'spanish' => [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ],
        'french' => [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',
        ],
        'english' => [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ]
    ];

    public function serializeImmutable(DateTimeImmutable $dateTime): array {
        $monthNumeral = (int)$dateTime->format('m');
        $monthLongNameFrench = self::$longMonthNames['french'][$monthNumeral];
        $monthLongNameSpanish = self::$longMonthNames['spanish'][$monthNumeral];
        $monthLongNameEnglish = self::$longMonthNames['english'][$monthNumeral];

        $escapedLongMonthNameFrench = $this->escapeLiteral($monthLongNameFrench);
        $escapedLongMonthNameSpanish = $this->escapeLiteral($monthLongNameSpanish);
        $escapedLongMonthNameEnglish = $this->escapeLiteral($monthLongNameEnglish);

        return [
            'components' => [
                'day' => (int)$dateTime->format('d'),
                'month' => (int)$dateTime->format('m'),
                'year' => (int)$dateTime->format('Y'),
                'hour' => (int)$dateTime->format('H'),
                'minute' => (int)$dateTime->format('i'),
                'second' => (int)$dateTime->format('s')
            ],
            'formatted' => [
                'longDate' => [
                    'spanish' => $dateTime->format("j \\d\\e $escapedLongMonthNameSpanish, Y"),
                    'english' => $dateTime->format("$escapedLongMonthNameEnglish jS, Y"),
                    'french' => $dateTime->format("$escapedLongMonthNameFrench j, Y"),
                ]
            ]
        ];
    }

    private function escapeLiteral(string $literal): string {
        $result = '';

        $len = strlen($literal);

        for ($i = 0; $i < $len; $i++) {
            $result .= '\\' . $literal[$i];
        }

        return $result;
    }
}
