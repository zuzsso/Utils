<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Object\Mocks;

use Utils\Cryptography\Random\Object\AbstractRandomToken;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;
use Utils\Cryptography\Random\Object\CharacterPool\HexadecimalLowerCaseCharacterPool;

class AbstractHexRandomTokenMock extends AbstractRandomToken {
    public static function getTokenExpectedLength(): int {
        return 32;
    }

    public static function getCharacterPool(): AbstractCharacterPool {
        return new HexadecimalLowerCaseCharacterPool();
    }
}
