<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Object;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;
use Utils\Cryptography\Random\Exception\InvalidHexStringTokenException;
use Utils\Cryptography\Random\Object\AbstractRandomToken;
use Utils\Cryptography\Random\Object\AbstractHexRandomToken;
use Utils\Tests\Cryptography\Object\Mocks\AbstractHexRandomTokenMock;

class AbstractHexRandomTokenTest extends TestCase {

    public function correctlyThrowsExceptionIfNotHexCharsPassedDataProvider(): array {
        return [
            ['                                '], // Invalid chars
            ['uNLxpjgUkwHpn7olKObxvrOiebnJt8Ek'],
            ["ÑÑÑÑÑÑÑÑÑÑÑÑÑÑÑÑ"] // 16 chars but 32 bytes, which is the required token length ;-)
        ];
    }

    /**
     * @param string $fixture
     * @return void
     * @dataProvider correctlyThrowsExceptionIfNotHexCharsPassedDataProvider
     * @throws InadequateTokenLengthException
     */
    public function testCorrectlyThrowsExceptionIfNotHexCharsPassed(string $fixture): void {
        $this->expectException(InvalidHexStringTokenException::class);
        $this->generateParametrizedSut($fixture);
    }

    public function testExtendsCorrectAbstractClass(): void {
        $reflectionClass = new ReflectionClass(AbstractHexRandomToken::class);

        self::assertEquals(AbstractRandomToken::class, $reflectionClass->getParentClass()->getName());
    }

    /**
     * @param string $randomToken
     * @return void
     * @throws InvalidHexStringTokenException
     * @throws InadequateTokenLengthException
     */
    private function generateParametrizedSut(string $randomToken): void {
        new AbstractHexRandomTokenMock($randomToken);
    }
}
