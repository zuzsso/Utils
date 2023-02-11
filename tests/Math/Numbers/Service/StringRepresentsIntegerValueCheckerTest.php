<?php

declare(strict_types=1);

namespace Utils\Tests\Math\Numbers\Service;

use PHPUnit\Framework\TestCase;
use Utils\Math\Numbers\Service\StringRepresentsIntegerValueChecker;

class StringRepresentsIntegerValueCheckerTest extends TestCase {

    private StringRepresentsIntegerValueChecker $sut;

    public function setUp(): void {
        parent::setUp();
        $this->sut = new StringRepresentsIntegerValueChecker();
    }

    /**
     * @return array
     */
    public function returnsCorrectValuePositiveOrZeroDataProvider(): array {
        return [
            ['123', true],
            ['abc', false],
            ['-123', false],
            ['1 2 3', false],
            ['a12b', false],
            ['abc12', false],
            ['12abc', false],
            ['12 abc', false]
        ];
    }

    /**
     * @dataProvider returnsCorrectValuePositiveOrZeroDataProvider
     * @param string $s
     * @param bool $expected
     * @return void
     */
    public function testReturnsCorrectValuesPositiveOrZero(string $s, bool $expected): void {
        $actual = $this->sut->checkPositiveOrZero($s);
        self::assertEquals($expected, $actual);
    }
}
