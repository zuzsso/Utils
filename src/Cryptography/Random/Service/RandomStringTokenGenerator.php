<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Service;

use Exception;
use InvalidArgumentException;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;
use Utils\Cryptography\Random\UseCase\GenerateRandomStringToken;

/**
 * @deprecated Use AbstractCrypToken class
 */
class RandomStringTokenGenerator implements GenerateRandomStringToken {
    /**
     * @throws Exception
     */
    public function generateRandomStringOfLengthInChars(
        AbstractCharacterPool $characterPool,
        int $lengthInChars
    ): string {
        $poolSize = $characterPool->characterPoolSize();

        if ($poolSize < 1) {
            throw new InvalidArgumentException('Character pool not big enough');
        }

        if ($lengthInChars < 1) {
            throw new InvalidArgumentException(
                "The current implementation only generates random strings of length [1, " .
                PHP_INT_MAX . "], but requested $lengthInChars"
            );
        }

        $result = '';

        while (strlen($result) < $lengthInChars) {
            $atRandom = random_int(0, $poolSize - 1);
            $result .= $characterPool->getCharAt($atRandom);
        }

        return $result;
    }
}
