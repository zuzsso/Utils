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
     * @deprecated
     */
    public function hexTokenOfLength(int $charLength): HexRandomToken;

    /**
     * @throws Exception
     * @throws InvalidArgumentException
     * @param int $charLength
     * @return string
     */
    public function hexTokenOfLengthRaw(int $charLength): string;
}
