<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Object;

use PHPUnit\Framework\TestCase;
use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;
use Utils\Cryptography\Random\Exception\InvalidHexStringTokenException;
use Utils\Cryptography\Random\Exception\TokenNotCompatibleWithCharacterPoolException;
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
     * @dataProvider correctlyThrowsExceptionIfNotHexCharsPassedDataProvider
     * @throws InadequateTokenLengthException
     * @throws TokenNotCompatibleWithCharacterPoolException
     */
    public function testCorrectlyThrowsExceptionIfNotHexCharsPassed(string $fixture): void {
        $this->expectException(TokenNotCompatibleWithCharacterPoolException::class);
        $this->generateParametrizedSut($fixture);
    }

    /**
     * @throws InadequateTokenLengthException
     * @throws TokenNotCompatibleWithCharacterPoolException
     */
    private function generateParametrizedSut(string $randomToken): void {
        new AbstractHexRandomTokenMock($randomToken);
    }
}
