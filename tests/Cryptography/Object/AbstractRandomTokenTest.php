<?php

declare(strict_types=1);


namespace Utils\Tests\Cryptography\Object;

use PHPUnit\Framework\TestCase;
use Utils\Cryptography\Random\Object\AbstractRandomToken;

class AbstractRandomTokenTest extends TestCase {
    public function testCorrectlyReturnsToken(): void {
        $randomToken = 'this is my random token';
        $sut = $this->getMockForAbstractClass(AbstractRandomToken::class, [$randomToken]);

        $actual = $sut->getStringToken();
        self::assertEquals($randomToken, $actual);
    }
}
