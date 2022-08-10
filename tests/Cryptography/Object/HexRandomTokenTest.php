<?php

declare(strict_types=1);


namespace Utils\Tests\Cryptography\Object;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Utils\Cryptography\Random\Exception\InvalidHexStringTokenException;
use Utils\Cryptography\Random\Object\AbstractRandomToken;
use Utils\Cryptography\Random\Object\HexRandomToken;

class HexRandomTokenTest extends TestCase {

    public function correctlyThrowsExceptionIfNotHexCharsPassedDataProvider(): array {
        return [
            [''], // Empty string, not an actual token
            [' '], // Invalid chars
            ['gh'],
            ["Ñ"]
        ];
    }

    /**
     * @param string $fixture
     * @return void
     * @dataProvider correctlyThrowsExceptionIfNotHexCharsPassedDataProvider
     */
    public function testCorrectlyThrowsExceptionIfNotHexCharsPassed(string $fixture): void {
        $this->expectException(InvalidHexStringTokenException::class);
        new HexRandomToken($fixture);
    }

    public function testExtendsCorrectAbstractClass(): void {
        $reflectionClass = new ReflectionClass(HexRandomToken::class);

        self::assertEquals(AbstractRandomToken::class, $reflectionClass->getParentClass()->getName());
    }
}
