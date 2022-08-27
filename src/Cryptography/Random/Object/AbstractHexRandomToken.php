<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Object;

use Utils\Cryptography\Random\Exception\InadequateTokenLengthException;
use Utils\Cryptography\Random\Exception\InvalidHexStringTokenException;

abstract class AbstractHexRandomToken extends AbstractRandomToken {
    /**
     * @throws InvalidHexStringTokenException
     * @throws InadequateTokenLengthException
     */
    public function __construct(string $token) {
        parent::__construct($token);

        $strLen = strlen($token);

        if ($strLen < 1) {
            throw new InvalidHexStringTokenException(
                "The required token length should be at least 1. Actual length: $strLen"
            );
        }

        $validChars = '0123456789abcdefABCDEF';

        for($i = 0; $i< $strLen; $i++) {
            if (strpos($validChars, $token[$i]) === false) {
                throw new InvalidHexStringTokenException(
                    "The only valid chars for a HEX random token are: '$validChars', but encountered: " . $token[$i]
                );
            }
        }
    }
}
