<?php

declare(strict_types=1);

namespace Utils\Tests\DateAndTime\Service;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Utils\DateAndTime\Service\DateTimeSerializer;

class DateTimeSerializerTest extends TestCase
{
    private DateTimeSerializer $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new DateTimeSerializer();
    }

    public function testCorrectlySerializes(): void
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
}
