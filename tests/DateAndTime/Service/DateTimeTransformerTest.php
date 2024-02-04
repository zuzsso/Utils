<?php

declare(strict_types=1);

namespace Utils\Tests\DateAndTime\Service;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
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
}
