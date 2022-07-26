<?php

declare(strict_types=1);


namespace Utils\Cryptography\Hash\Service;

use Utils\Cryptography\Hash\UseCase\PasswordHash;
use Utils\Cryptography\Hash\UseCase\PasswordVerify;

class HashService implements PasswordHash, PasswordVerify {
    /**
     * @inheritDoc
     */
    public function passwordHash(string $clearTextString): string {
        return sodium_crypto_pwhash_str(
            $clearTextString,
            SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
            SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE
        );
    }

    /**
     * @inheritDoc
     */
    public function verifyPassword(string $hash, string $clearTextPassword): bool {
        return sodium_crypto_pwhash_str_verify($hash, $clearTextPassword);
    }
}

