<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Service;

use Exception;
use InvalidArgumentException;
use Throwable;
use Utils\Cryptography\Random\Exception\UnableToGenerateRandomTokenGeneralException;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;
use Utils\Cryptography\Random\UseCase\GenerateRandomStringToken;

class RandomStringTokenGenerator implements GenerateRandomStringToken {

    /**
     * @inheritDoc
     * @deprecated use 'GenerateRandomStringToken::generateRandomStringOfLengthInChars()' method
     */
    public function hexTokenOfLength(int $charLength): string {
        if ($charLength < 1) {
            throw new InvalidArgumentException("Minimum length is 1, but passed $charLength");
        }

        try {
            $raw = bin2hex(random_bytes($charLength));
            return substr($raw, 0, $charLength);
        } catch (Throwable $e) {
            throw new UnableToGenerateRandomTokenGeneralException(null, null, $e);
        }
    }

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
