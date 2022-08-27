<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Object;

use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;

abstract class AbstractRandomToken {
    protected string $token;

    /**
     * @param string $token
     * @throws InadequateTokenLengthException
     */
    public function __construct(string $token) {

        $l = static::getLength();
        $a = strlen($token);

        if ($a !== static::getLength()) {
            throw new InadequateTokenLengthException(
                "This token is required to be of $l chars long, but got $a: '$token'"
            );
        }

        $this->token = $token;
    }

    public function getStringToken(): string {
        return $this->token;
    }

    abstract public static function getLength(): int;
}
