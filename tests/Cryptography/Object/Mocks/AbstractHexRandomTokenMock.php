<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Object\Mocks;

use Utils\Cryptography\Random\Object\AbstractHexRandomToken;

class AbstractHexRandomTokenMock extends AbstractHexRandomToken {
    public static function getLength(): int {
        return 32;
    }
}
