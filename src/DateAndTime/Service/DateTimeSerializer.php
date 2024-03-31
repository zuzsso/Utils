<?php

declare(strict_types=1);

namespace Utils\DateAndTime\Service;

use DateTimeImmutable;
use Utils\DateAndTime\UseCase\SerializeDateTime;
use Utils\Language\Type\Language\AbstractLanguage;
use Utils\Language\Type\Language\English;
use Utils\Language\Type\Language\French;
use Utils\Language\Type\Language\Spanish;

class DateTimeSerializer implements SerializeDateTime
{
    private function getLongMonthNames(): array
    {
        return [
            Spanish::getApiLiteral() => [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre',
            ],
            French::getApiLiteral() => [
                'janvier',
                'février',
                'mars',
                'avril',
                'mai',
                'juin',
                'juillet',
                'août',
                'septembre',
                'octobre',
                'novembre',
                'décembre',
            ],
            English::getApiLiteral() => [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December',
            ],
        ];
    }

    private function getShortMonthNames(): array
    {
        return [
            Spanish::getApiLiteral() => [
                'Ene',
                'Feb',
                'Mar',
                'Abr',
                'May',
                'Jun',
                'Jul',
                'Ago',
                'Sep',
                'Oct',
                'Nov',
                'Dic',
            ],
            French::getApiLiteral() => [
                'jan',
                'fév',
                'mar',
                'avr',
                'mai',
                'jui',
                'jui',
                'aoû',
                'sep',
                'oct',
                'nov',
                'déc',
            ],
            English::getApiLiteral() => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
            ],
        ];
    }

    private function serializeComponents(DateTimeImmutable $dateTime): array
    {
        return [
            'day' => (int)$dateTime->format('d'),
            'month' => (int)$dateTime->format('m'),
            'year' => (int)$dateTime->format('Y'),
            'hour' => (int)$dateTime->format('H'),
            'minute' => (int)$dateTime->format('i'),
            'second' => (int)$dateTime->format('s'),
        ];
    }

    /**
     * @deprecated
     * @see \Utils\DateAndTime\Service\DateTimeSerializer::serializeImmutableForLanguage
     */
    public function serializeImmutable(DateTimeImmutable $dateTime): array
    {
        $monthNumeralZeroBased = (int)$dateTime->format('m') - 1;

        $longMonthNames = $this->getLongMonthNames();


        $monthLongNameFrench = $longMonthNames[French::getApiLiteral()][$monthNumeralZeroBased];
        $monthLongNameSpanish = $longMonthNames[Spanish::getApiLiteral()][$monthNumeralZeroBased];
        $monthLongNameEnglish = $longMonthNames[English::getApiLiteral()][$monthNumeralZeroBased];

        $escapedLongMonthNameFrench = $this->escapeLiteral($monthLongNameFrench);
        $escapedLongMonthNameSpanish = $this->escapeLiteral($monthLongNameSpanish);
        $escapedLongMonthNameEnglish = $this->escapeLiteral($monthLongNameEnglish);

        return [
            'components' => $this->serializeComponents($dateTime),
            'formatted' => [
                'longDate' => [
                    'spanish' => $dateTime->format("j \\d\\e $escapedLongMonthNameSpanish, Y"),
                    'english' => $dateTime->format("$escapedLongMonthNameEnglish jS, Y"),
                    'french' => $dateTime->format("$escapedLongMonthNameFrench j, Y"),
                ],
            ],
        ];
    }

    public function serializeImmutableForLanguage(DateTimeImmutable $dateTime, AbstractLanguage $lan): array
    {
        $monthNumeralZeroBased = (int)$dateTime->format('m') - 1;

        $longMonthNames = $this->getLongMonthNames();

        if ($lan instanceof French) {
            $monthLongNameFrench = $longMonthNames[French::getApiLiteral()][$monthNumeralZeroBased];
            $escapedLongMonthNameFrench = $this->escapeLiteral($monthLongNameFrench);
            $long = $dateTime->format("$escapedLongMonthNameFrench j, Y");
        } elseif ($lan instanceof Spanish) {
            $monthLongNameSpanish = $longMonthNames[Spanish::getApiLiteral()][$monthNumeralZeroBased];
            $escapedLongMonthNameSpanish = $this->escapeLiteral($monthLongNameSpanish);
            $long = $dateTime->format("j \\d\\e $escapedLongMonthNameSpanish, Y");
        } else {
            $monthLongName = $longMonthNames[$lan::getApiLiteral()][$monthNumeralZeroBased];
            $escapedLongMonthName = $this->escapeLiteral($monthLongName);
            $long = $dateTime->format("$escapedLongMonthName jS, Y");
        }

        return [
            'components' => $this->serializeComponents($dateTime),
            'formatted' => [
                'longDate' => $long,
                'dateTimeMonospace' => $this->formatDateTimeMonospace24H($dateTime, $lan),
                'dateMonospace' => $this->formatDateMonospace($dateTime, $lan),
                'time24H' => $dateTime->format('H:i:s')
            ],
        ];
    }

    /**
     * @noinspection DuplicatedCode
     */
    private function formatDateTimeMonospace24H(DateTimeImmutable $dateTime, AbstractLanguage $lan): string
    {
        $monthNumeralZeroBased = (int)$dateTime->format('m') - 1;

        $shortMonthNames = $this->getShortMonthNames();

        if ($lan instanceof French) {
            $monthShortName = $shortMonthNames[French::getApiLiteral()][$monthNumeralZeroBased];
        } elseif ($lan instanceof Spanish) {
            $monthShortName = $shortMonthNames[Spanish::getApiLiteral()][$monthNumeralZeroBased];
        } else {
            $monthShortName = $shortMonthNames[$lan::getApiLiteral()][$monthNumeralZeroBased];
        }

        return $dateTime->format('d') . " $monthShortName " . $dateTime->format('Y') . ' ' . $dateTime->format('H:i:s');

    }

    /**
     * @noinspection DuplicatedCode
     */
    private function formatDateMonospace(DateTimeImmutable $dateTime, AbstractLanguage $lan): string
    {
        $monthNumeralZeroBased = (int)$dateTime->format('m') - 1;

        $shortMonthNames = $this->getShortMonthNames();

        if ($lan instanceof French) {
            $monthShortName = $shortMonthNames[French::getApiLiteral()][$monthNumeralZeroBased];
        } elseif ($lan instanceof Spanish) {
            $monthShortName = $shortMonthNames[Spanish::getApiLiteral()][$monthNumeralZeroBased];
        } else {
            $monthShortName = $shortMonthNames[$lan::getApiLiteral()][$monthNumeralZeroBased];
        }

        return $dateTime->format('d') . " $monthShortName " . $dateTime->format('Y');

    }

    private function escapeLiteral(string $literal): string
    {
        $result = '';

        $len = strlen($literal);

        for ($i = 0; $i < $len; $i++) {
            $result .= '\\' . $literal[$i];
        }

        return $result;
    }
}
