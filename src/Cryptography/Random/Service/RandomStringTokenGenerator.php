<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Service;

use InvalidArgumentException;
use Throwable;
use Utils\Cryptography\Random\Exception\UnableToGenerateRandomTokenGeneralException;
use Utils\Cryptography\Random\UseCase\GenerateRandomStringToken;

class RandomStringTokenGenerator implements GenerateRandomStringToken {

    /**
     * @inheritDoc
     */
    public function hexTokenOfLengthRaw(int $charLength): string {
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
}
