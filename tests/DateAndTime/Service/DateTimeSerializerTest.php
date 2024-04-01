<?php

declare(strict_types=1);

namespace Utils\Tests\DateAndTime\Service;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Utils\DateAndTime\Service\DateTimeSerializer;
use Utils\Language\Type\Language\English;

class DateTimeSerializerTest extends TestCase
{
    private DateTimeSerializer $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new DateTimeSerializer();
    }

    public function testCorrectlySerializesDeprecated(): void
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-07-08 18:35:45');
        $actual = $this->sut->serializeImmutable($date);

        $expected = [
            'components' => [
                'day' => 8,
                'month' => 7,
                'year' => 2023,
                'hour' => 18,
                'minute' => 35,
                'second' => 45
            ],
            'formatted' => [
                'longDate' => [
                    'spanish' => '8 de Julio, 2023',
                    'english' => 'July 8th, 2023',
                    'french' => 'juillet 8, 2023'
                ]
            ]
        ];

        self::assertEquals($expected, $actual);
    }

    public function testCorrectlySerializes(): void
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-07-08 18:35:45');
        $actual = $this->sut->serializeImmutableForLanguage($date, new English());

        $expected = [
            'components' => [
                'day' => 8,
                'month' => 7,
                'year' => 2023,
                'hour' => 18,
                'minute' => 35,
                'second' => 45
            ],
            'formatted' => [
                'longDate' => 'July 8th, 2023',
                'dateTimeMonospace' => '08 Jul 2023 18:35:45',
                'time24H' => '18:35:45',
                'dateMonospace' => '08 Jul 2023'
            ]
        ];

        self::assertEquals($expected, $actual);
    }
}
