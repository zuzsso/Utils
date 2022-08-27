<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Service;

use InvalidArgumentException;
use Utils\Cryptography\Random\Object\HexRandomToken;
use Utils\Cryptography\Random\UseCase\GenerateRandomStringToken;

class RandomStringTokenGenerator implements GenerateRandomStringToken {

    /**
     * @inheritDoc
     */
    public function hexTokenOfLength(int $charLength): HexRandomToken {

        return new HexRandomToken($this->hexTokenOfLengthRaw($charLength));
    }

    /**
     * @inheritDoc
     */
    public function hexTokenOfLengthRaw(int $charLength): string {
        if ($charLength < 1) {
            throw new InvalidArgumentException("Minimum length is 1, but passed $charLength");
        }

        $raw = bin2hex(random_bytes($charLength));

        return substr($raw, 0, $charLength);
    }
}
