<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Type;

use Exception;
use InvalidArgumentException;
use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;
use Utils\Cryptography\Random\Exception\TokenNotCompatibleWithCharacterPoolException;
use Utils\Cryptography\Random\Exception\UnableToGenerateRandomTokenUnmanagedException;
use Utils\Cryptography\Random\Type\CharacterPool\AbstractCharacterPool;

/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
abstract class AbstractCrypToken
{
    private string $crypToken;

    /**
     * @throws InadequateTokenLengthException
     * @throws TokenNotCompatibleWithCharacterPoolException
     * @throws UnableToGenerateRandomTokenUnmanagedException
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function __construct(?string $crypToken = null)
    {
        $characterPool = $this->getCharacterPool();
        $tokenLengthInOneByteChars = $this->getTokenLengthInOneByteChars();

        $this->validateCharacterPool($characterPool);
        $this->validateLength($tokenLengthInOneByteChars);

        if ($crypToken === null) {
            $this->crypToken = $this->generateNewCryptoken(
                $characterPool,
                $tokenLengthInOneByteChars
            );
        } else {
            $this->crypToken = $crypToken;
            $this->checkLength($this->crypToken, $tokenLengthInOneByteChars);
            $this->checkTokenCompatibleWithCharacterPool($characterPool, $this->crypToken);
        }
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    private function validateLength(int $tokenLengthInOneByteChars): void
    {
        if ($tokenLengthInOneByteChars < 1) {
            throw new InvalidArgumentException(
                "The current implementation only generates random strings of length [1, " .
                PHP_INT_MAX . "], but requested $tokenLengthInOneByteChars"
            );
        }
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    private function validateCharacterPool(AbstractCharacterPool $characterPool): void
    {
        $poolSize = $characterPool->characterPoolSize();

        if ($poolSize < 1) {
            throw new InvalidArgumentException('Character pool not big enough');
        }
    }

    /**
     * @throws UnableToGenerateRandomTokenUnmanagedException
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    private function generateNewCryptoken(
        AbstractCharacterPool $characterPool,
        int $tokenLengthInOneByteChars
    ): string {
        $poolSize = $characterPool->characterPoolSize();

        $result = '';

        while (strlen($result) < $tokenLengthInOneByteChars) {
            try {
                $atRandom = random_int(0, $poolSize - 1);
            } catch (Exception $e) {
                throw new UnableToGenerateRandomTokenUnmanagedException(
                    "Could not generate a random integer using PHP native functions",
                    $e->getCode(),
                    $e
                );
            }
            $result .= $characterPool->getCharAt($atRandom);
        }

        return $result;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    abstract public function getCharacterPool(): AbstractCharacterPool;

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    abstract public function getTokenLengthInOneByteChars(): int;

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function getCryptokenAsString(): string
    {
        return $this->crypToken;
    }

    /**
     * @throws TokenNotCompatibleWithCharacterPoolException
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    private function checkTokenCompatibleWithCharacterPool(
        AbstractCharacterPool $characterPool,
        string $crypToken
    ): void {
        if (!$characterPool->checkStringIsCompatibleWithCharacterPool($crypToken)) {
            $allowed = $characterPool->getCharacterPoolAsSingleString();
            throw new TokenNotCompatibleWithCharacterPoolException(
                "This token contains character outside the allowed character pool. Make " .
                "sure it only contains characters from this list: '$allowed'. Given: '$crypToken'"
            );
        }
    }

    /**
     * @throws InadequateTokenLengthException
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    private function checkLength(string $crypToken, int $expectedTokenLength): void
    {
        $a = strlen($crypToken);

        if ($a !== $expectedTokenLength) {
            throw new InadequateTokenLengthException(
                "This token is required to be of $expectedTokenLength chars long, but got $a: '$crypToken'"
            );
        }
    }
}
