<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\UseCase;

use Exception;
use InvalidArgumentException;

interface GenerateRandomStringToken {
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function hexTokenOfLength(int $charLength): string;
}
