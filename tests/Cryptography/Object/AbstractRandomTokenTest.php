<?php

declare(strict_types=1);


namespace Utils\Tests\Cryptography\Object;

use PHPUnit\Framework\TestCase;
use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;
use Utils\Tests\Cryptography\Object\Mocks\AbstractRandomTokenMock;

class AbstractRandomTokenTest extends TestCase {
    /**
     * @throws InadequateTokenLengthException
     */
    public function testCorrectlyReturnsToken(): void {
        $randomToken = 'aQmkvgcF6lfkUvnYJO7gkDYtZ4mAsc0J';
        $sut = new AbstractRandomTokenMock($randomToken);

        $actual = $sut->getStringToken();
        self::assertEquals($randomToken, $actual);
    }

    public function testThrowsExceptionIfIncorrectLength(): void {
        $this->expectException(InadequateTokenLengthException::class);
        $this->expectExceptionMessage(
            "This token is required to be of 32 chars long, but got 35: 'expected 32, but got something else'"
        );
        new AbstractRandomTokenMock('expected 32, but got something else');
    }
}
