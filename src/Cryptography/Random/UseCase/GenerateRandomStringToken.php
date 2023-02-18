<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\UseCase;

use Utils\Cryptography\Random\Exception\UnableToGenerateRandomTokenGeneralException;

interface GenerateRandomStringToken {
    /**
     * @throws UnableToGenerateRandomTokenGeneralException
     */
    public function hexTokenOfLength(int $charLength): string;
}
