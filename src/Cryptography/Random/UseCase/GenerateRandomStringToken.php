<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\UseCase;

use Exception;
use InvalidArgumentException;
use Utils\Cryptography\Random\Object\HexRandomToken;

interface GenerateRandomStringToken {
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function hexTokenOfLength(int $charLength): HexRandomToken;
}
