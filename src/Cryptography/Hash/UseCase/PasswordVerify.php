<?php

declare(strict_types=1);

namespace Utils\Cryptography\Hash\UseCase;

use SodiumException;

interface PasswordVerify
{
    /**
     * @param string $hash
     * @param string $clearTextPassword
     * @return bool
     * @throws SodiumException
     */
    public function verifyPassword(string $hash, string $clearTextPassword): bool;
}
