<?php

declare(strict_types=1);


namespace Utils\Cryptography\Hash\UseCase;

interface GenerateStringHash {
    /**
     * @param string $clearTextString
     * @return string
     */
    public function useSha256HexOutput(string $clearTextString): string;
}
