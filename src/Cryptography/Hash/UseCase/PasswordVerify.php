<?php

declare(strict_types=1);

namespace Utils\Cryptography\Hash\UseCase;

use SodiumException;
/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
interface PasswordVerify
{
    /**
     * @param string $hash
     * @param string $clearTextPassword
     *
     * @return bool
     * @throws SodiumException
     * @deprecated
     * Migrated to zuzsso/cryptography
     */
    public function verifyPassword(string $hash, string $clearTextPassword): bool;
}
