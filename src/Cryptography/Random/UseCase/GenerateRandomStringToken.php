<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\UseCase;

use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;

/**
 * @deprecated Use AbstractCryptToken
 */
interface GenerateRandomStringToken {
    public function generateRandomStringOfLengthInChars(
        AbstractCharacterPool $characterPool,
        int $lengthInChars
    ): string;
}
