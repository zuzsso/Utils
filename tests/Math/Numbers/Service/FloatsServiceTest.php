<?php

declare(strict_types=1);

namespace Utils\Tests\Math\Numbers\Service;

use PHPUnit\Framework\TestCase;
use Utils\Math\Numbers\Service\FloatsService;

class FloatsServiceTest extends TestCase
{
    private FloatsService $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new FloatsService();
    }

    public function comparesCorrectlyDataProvider(): array
    {
        return [
            [0, 0, true],
            [1, 1, true],
            [-1, -1, true],

            [1.001, 1.001, true],
            [1.001, 1.002, false],
            [PHP_FLOAT_EPSILON, PHP_FLOAT_EPSILON, true],

            [1 - PHP_FLOAT_EPSILON, 1, true],
            [1 + PHP_FLOAT_EPSILON, 1, true],

            [1 + (PHP_FLOAT_EPSILON) * 2, 1, false],

            [1, 1 - PHP_FLOAT_EPSILON, true],
            [1, 1 + PHP_FLOAT_EPSILON, true],
            [1, 1 + (PHP_FLOAT_EPSILON) * 2, false],
        ];
    }

    /**
     * @param float $f1
     * @param float $f2
     * @param bool $expected
     * @return void
     * @dataProvider comparesCorrectlyDataProvider
     */
    public function testComparesCorrectly(float $f1, float $f2, bool $expected): void
    {
        $actual = $this->sut->equalFloats($f1, $f2, PHP_FLOAT_EPSILON);

        self::assertEquals($expected, $actual);
    }
}
