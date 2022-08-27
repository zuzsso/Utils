<?php

declare(strict_types=1);


namespace Utils\Tests\Cryptography\Object\Mocks;

use Utils\Cryptography\Random\Object\AbstractRandomToken;

class AbstractRandomTokenMock extends AbstractRandomToken {
    public static function getLength(): int {
        return 32;
    }
}
