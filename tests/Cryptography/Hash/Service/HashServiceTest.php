<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Hash\Service;

use PHPUnit\Framework\TestCase;
use SodiumException;
use Utils\Cryptography\Hash\Service\HashService;

class HashServiceTest extends TestCase
{
    private HashService $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new HashService();
    }

    /**
     * @return void
     * @throws SodiumException
     */
    public function testHashesCorrectly(): void
    {
        $hash = $this->sut->passwordHash('me testing');

        self::assertStringContainsString('$argon2id$v=19$m=65536,t=2,p=', $hash);

    }

    /**
     * @return void
     * @throws SodiumException
     */
    public function testVerifiesCorrectly(): void
    {
        $storedHash = '$argon2id$v=19$m=65536,t=2,p=1$wxPZ7GMy466cijsVYDJexw$FCn5ZBcDHh05gMWMIWRjIpykFS7TGPr2JEUj73AOXco';

        self::assertTrue($this->sut->verifyPassword($storedHash, 'me testing'));

        self::assertFalse($this->sut->verifyPassword($storedHash . 'tampered', 'me testing'));
    }
}
