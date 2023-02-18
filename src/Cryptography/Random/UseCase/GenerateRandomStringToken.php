<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\UseCase;

use Exception;
use Utils\Cryptography\Random\Exception\UnableToGenerateRandomTokenGeneralException;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;

interface GenerateRandomStringToken {
    /**
     * @throws UnableToGenerateRandomTokenGeneralException
     * @throws Exception
     * @deprecated use 'GenerateRandomStringToken::generateRandomStringOfLengthInChars()' method, and pass an
     * instance of HexadecimalLowerCaseCharacterPool as parameter
     */
    public function hexTokenOfLength(int $charLength): string;

    public function generateRandomStringOfLengthInChars(
        AbstractCharacterPool $characterPool,
        int $lengthInChars
    ): string;
}
