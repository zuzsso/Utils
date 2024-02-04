<?php

declare(strict_types=1);

namespace Utils\Tests\DateAndTime\Service;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Utils\DateAndTime\Exception\DatetimeCommonOperationsUnmanagedException;
use Utils\DateAndTime\Service\DateTimeTransformer;

class DateTimeTransformerTest extends TestCase
{
    private DateTimeTransformer $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new DateTimeTransformer();
    }

    public function testCorrectlyRemovesTimeFromDate(): void
    {
        $dateTimeFixture = DateTimeImmutable::createFromFormat(DateTimeInterface::ATOM, '2005-08-15T15:52:01+12:34');

        $actual = $this->sut->removeTime($dateTimeFixture);

        $actualFormatted = $actual->format(DateTimeInterface::ATOM);

        self::assertEquals('2005-08-15T00:00:00+12:34', $actualFormatted);
    }

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function testCorrectlyAddsDaysToDate(): void
    {
        $fixture = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2024-02-04 21:26:00');

        $actual = $this->sut->addDays($fixture, 3);

        self::assertEquals('2024-02-07 21:26:00', $actual->format('Y-m-d H:i:s'));
    }

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function testCorrectlySubstractsDaysToDate(): void
    {
        $fixture = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2024-02-04 21:26:00');

        $actual = $this->sut->substractDays($fixture, 3);

        self::assertEquals('2024-02-01 21:26:00', $actual->format('Y-m-d H:i:s'));
    }

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function testCorrectlyAddsSecondsToDate(): void
    {
        $fixture = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2024-02-04 21:26:00');

        $actual = $this->sut->addSeconds($fixture, 3);

        self::assertEquals('2024-02-04 21:26:03', $actual->format('Y-m-d H:i:s'));
    }

    /**
     * @throws DatetimeCommonOperationsUnmanagedException
     */
    public function testCorrectlySubstractsSecondsToDate(): void
    {
        $fixture = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2024-02-04 21:26:00');

        $actual = $this->sut->substractSeconds($fixture, 3);

        self::assertEquals('2024-02-04 21:25:57', $actual->format('Y-m-d H:i:s'));
    }

    public function incorrectValuesDataProvider(): array
    {
        $dt = new DateTimeImmutable();

        $functionsToBeTested = [
            'substractDays',
            'substractSeconds',
            'addSeconds',
            'addDays'
        ];

        $testCaseScenarios = [];

        foreach ($functionsToBeTested as $f) {
            $testCaseScenarios[] = [$f, $dt, 0];
            $testCaseScenarios[] = [$f, $dt, -1];
        }

        return $testCaseScenarios;
    }

    /**
     * @dataProvider incorrectValuesDataProvider
     */
    public function testSubstractDaysThrowsCorrectException(
        string $functionName,
        DateTimeImmutable $dt,
        int $incorrectValue
    ): void {
        $this->expectException(DatetimeCommonOperationsUnmanagedException::class);
        $this->sut->$functionName($dt, $incorrectValue);
    }
}
