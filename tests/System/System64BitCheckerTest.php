<?php

declare(strict_types=1);


namespace Utils\Tests\System;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Utils\System\Service\System64BitChecker;
use Utils\System\UseCase\CalculateSigned64BitIntFromString;
use Utils\System\UseCase\CalculateSizeOfOnesComplementOfZero;
use Utils\System\UseCase\GetOSDescription;
use Utils\System\UseCase\GetPhpIntSizeConstant;

class System64BitCheckerTest extends TestCase {

    private System64BitChecker $sut;

    /**
     * @var GetPhpIntSizeConstant | MockObject
     */
    private $getPhpIntSizeConstant;

    /**
     * @var CalculateSizeOfOnesComplementOfZero | MockObject
     */
    private $calculateSizeOfOnesComplementOfZero;

    /**
     * @var GetOSDescription | MockObject
     */
    private $getOSDescription;

    /**
     * @var CalculateSigned64BitIntFromString | MockObject
     */
    private $calculateSigned64BitIntFromString;

    public function setUp(): void {
        parent::setUp();

        $this->getPhpIntSizeConstant = $this->createMock(GetPhpIntSizeConstant::class);
        $this->calculateSizeOfOnesComplementOfZero = $this->createMock(CalculateSizeOfOnesComplementOfZero::class);
        $this->getOSDescription = $this->createMock(GetOSDescription::class);
        $this->calculateSigned64BitIntFromString = $this->createMock(CalculateSigned64BitIntFromString::class);

        $this->sut = new System64BitChecker(
            $this->getPhpIntSizeConstant,
            $this->calculateSizeOfOnesComplementOfZero,
            $this->getOSDescription,
            $this->calculateSigned64BitIntFromString
        );
    }

    public function is64BitSystemDataProvider(): array {
        return [
            ['64'],
            [' 64 '],
            ['_64_'],
            ['x86_64'],
            ['x86-64'],
        ];
    }

    /**
     * @param string $osDescription
     * @return void
     * @dataProvider is64BitSystemDataProvider
     */
    public function testIs64BitSystem(string $osDescription): void {
        $this->getPhpIntSizeConstant->expects(self::once())->method('get')->willReturn(8);
        $this->calculateSizeOfOnesComplementOfZero->expects(self::once())->method('calculate')->willReturn(64);
        $this->getOSDescription->expects(self::once())->method('get')->willReturn($osDescription);
        $this
            ->calculateSigned64BitIntFromString
            ->expects(self::once())
            ->method('calculate')
            ->willReturn(9223372036854775807);

        self::assertTrue($this->sut->is64Bits());
    }

    /**
     * @return array
     */
    public function isNot64BitSystemDataProvider(): array {
        // All good except the int size constant
        $suite01 = [
            [4, 64, '64', 9223372036854775807],
            [5, 64, '64', 9223372036854775807],
            [6, 64, '64', 9223372036854775807],
            [7, 64, '64', 9223372036854775807],
            [9, 64, '64', 9223372036854775807],

        ];

        // All good except the size of Ones Complement of zero
        $suite02 = [
            [8, 32, '64', 9223372036854775807],
            [8, 63, '64', 9223372036854775807],
            [8, 65, '64', 9223372036854775807],
        ];

        // All good except the OS description
        $suite03 = [
            [8, 64, 'i586', 9223372036854775807],
            [8, 64, '__', 9223372036854775807],
            [8, 64, 'blah', 9223372036854775807],
            [8, 64, '6 4', 9223372036854775807],
            [8, 64, 'i586.4', 9223372036854775807],
        ];

        // All good except the max int string conversion to integer
        $suite04 = [
            [8, 64, 'x86_64', 9223372036854775806],
            [8, 64, 'x86_64', 9223372036854775],
            [8, 64, 'x86_64', 0],
            [8, 64, 'x86_64', 25],
            [8, 64, 'x86_64', -1],
        ];

        return array_merge($suite01, $suite02, $suite03, $suite04);
    }

    /**
     * @param int $intSizeConstant
     * @param int $sizeOneComplement
     * @param string $osDescription
     * @param int $intFromString
     * @return void
     * @dataProvider isNot64BitSystemDataProvider
     */
    public function testIsNot64BitSystem(
        int $intSizeConstant,
        int $sizeOneComplement,
        string $osDescription,
        int $intFromString
    ): void {
        $this->getPhpIntSizeConstant->expects(self::once())->method('get')->willReturn($intSizeConstant);

        $this
            ->calculateSizeOfOnesComplementOfZero
            ->expects(self::once())
            ->method('calculate')
            ->willReturn($sizeOneComplement);

        $this->getOSDescription->expects(self::once())->method('get')->willReturn($osDescription);
        $this->calculateSigned64BitIntFromString->expects(self::once())->method('calculate')->willReturn($intFromString);

        self::assertFalse($this->sut->is64Bits());
    }
}
