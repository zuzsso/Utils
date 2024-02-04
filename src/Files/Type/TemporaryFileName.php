<?php

declare(strict_types=1);

namespace Utils\Files\Type;

use Utils\Cryptography\Random\Object\AbstractCrypToken;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;
use Utils\Cryptography\Random\Object\CharacterPool\AlphanumericCaseSensitive;

class TemporaryFileName extends AbstractCrypToken
{
    public function getCharacterPool(): AbstractCharacterPool
    {
        return new AlphanumericCaseSensitive();
    }

    public function getTokenLengthInOneByteChars(): int
    {
        return 24;
    }
}
