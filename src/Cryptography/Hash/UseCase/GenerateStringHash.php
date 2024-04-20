<?php

declare(strict_types=1);

namespace Utils\Cryptography\Hash\UseCase;

/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
interface GenerateStringHash
{
    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     * @param string $clearTextString
     * @return string
     */
    public function useSha256HexOutput(string $clearTextString): string;
}
