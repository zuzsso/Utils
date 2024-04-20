<?php

declare(strict_types=1);

namespace Utils\Cryptography\Hash\UseCase;

use SodiumException;

/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
interface PasswordHash
{
    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     * @param string $clearTextString
     * @return string
     * @throws SodiumException
     */
    public function passwordHash(string $clearTextString): string;
}
