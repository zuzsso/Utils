<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Type\CharacterPool;

use InvalidArgumentException;
use OutOfBoundsException;

/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
abstract class AbstractCharacterPool
{
    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    protected array $characterPool = [];

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    protected function addCharacterToPool(string $char): void
    {
        if (strlen($char) !== 1) {
            throw new InvalidArgumentException(
                "This current implementation doesn't support multi char strings, empty strings " .
                "or multi-byte encoded chars in the character pool"
            );
        }

        if (in_array($char, $this->characterPool, true)) {
            throw new InvalidArgumentException("Character '$char' already exists in the pool");
        }

        $this->characterPool[] = $char;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function characterPoolSize(): int
    {
        return count($this->characterPool);
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function getCharacterPoolAsSingleString(): string
    {
        return implode('', $this->characterPool);
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function getCharAt(int $zeroBasedPosition): string
    {
        $poolSize = $this->characterPoolSize();
        $upperLimit = $poolSize - 1;
        if (($zeroBasedPosition < 0) || ($zeroBasedPosition > $upperLimit)) {
            throw new OutOfBoundsException("Position $zeroBasedPosition outside of interval [0, $upperLimit]");
        }

        return $this->characterPool[$zeroBasedPosition];
    }

    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function checkStringIsCompatibleWithCharacterPool(string $s): bool
    {
        $characterPoolOneLine = $this->getCharacterPoolAsSingleString();
        $stringLengh = strlen($s);

        for ($i = 0; $i < $stringLengh; $i++) {
            $thisChar = $s[$i];

            if (strpos($characterPoolOneLine, $thisChar) === false) {
                return false;
            }
        }

        return true;
    }
}
