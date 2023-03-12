<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Object;

use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;
use Utils\Cryptography\Random\Exception\TokenNotCompatibleWithCharacterPoolException;
use Utils\Cryptography\Random\Object\CharacterPool\AbstractCharacterPool;

abstract class AbstractRandomToken {
    protected string $token;

    /**
     * @throws InadequateTokenLengthException
     * @throws TokenNotCompatibleWithCharacterPoolException
     */
    public function __construct(string $token) {

        $this->token = $token;
        $this->checkLength();
        $this->checkTokenCompatibleWithCharacterPool();
    }

    /**
     * @throws TokenNotCompatibleWithCharacterPoolException
     */
    private function checkTokenCompatibleWithCharacterPool(): void {
        $characterPool = static::getCharacterPool();
        if (!$characterPool->checkStringIsCompatibleWithCharacterPool($this->token)) {
            $allowed = $characterPool->getCharacterPoolAsSingleString();
            throw new TokenNotCompatibleWithCharacterPoolException(
                "This token contains character outside the allowed character pool. Make '.
                'sure it only contains characters from this list: '$allowed'. Given: '$this->token'"
            );
        }
    }

    /**
     * @throws InadequateTokenLengthException
     */
    private function checkLength(): void {
        $l = static::getTokenExpectedLength();
        $a = strlen($this->token);

        if ($a !== static::getTokenExpectedLength()) {
            throw new InadequateTokenLengthException(
                "This token is required to be of $l chars long, but got $a: '$this->token'"
            );
        }
    }

    public function getStringToken(): string {
        return $this->token;
    }

    abstract public static function getTokenExpectedLength(): int;

    abstract public static function getCharacterPool(): AbstractCharacterPool;
}
