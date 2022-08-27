<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\UseCase;

use Utils\Cryptography\Random\Exception\InvalidHexStringTokenException;
use Utils\Cryptography\Random\Exception\UnableToGenerateRandomTokenGeneralException;
use Utils\Cryptography\Random\Object\HexRandomToken;

interface GenerateRandomStringToken {
    /**
     * @param int $charLength
     * @return HexRandomToken
     * @throws UnableToGenerateRandomTokenGeneralException
     * @throws InvalidHexStringTokenException
     */
    public function hexTokenOfLength(int $charLength): HexRandomToken;

    /**
     * @param int $charLength
     * @return string
     * @throws UnableToGenerateRandomTokenGeneralException
     */
    public function hexTokenOfLengthRaw(int $charLength): string;
}
