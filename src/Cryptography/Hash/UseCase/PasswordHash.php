<?php

declare(strict_types=1);


namespace Utils\Cryptography\Hash\UseCase;

use SodiumException;

interface PasswordHash {
    /**
     * @param string $clearTextString
     * @return string
     * @throws SodiumException
     */
    public function passwordHash(string $clearTextString): string;
}

