<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Random\CharacterPool;

use PHPUnit\Framework\TestCase;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;
use Utils\Cryptography\Random\Object\CharacterPool\MfaRecoveryCodeCharacterPool;

class MfaRecoveryCodeCharacterPoolTest extends TestCase {
    private MfaRecoveryCodeCharacterPool $sut;

    public function setUp(): void {
        parent::setUp();
        $this->sut = new MfaRecoveryCodeCharacterPool();
    }

    public function testHasExpectedCharacters(): void {
        $actual = $this->sut->getCharacterPoolAsSingleString();
        self::assertEquals('23456789BCDFGHJKLMNPQRSTVWXYZ', $actual);
    }

    public function testExtendsExpectedClass(): void {
        self::assertInstanceOf(AbstractCharacterPool::class, $this->sut);
    }
}
