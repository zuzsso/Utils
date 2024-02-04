<?php

namespace Utils\Files\UseCase;

interface CheckFileExists
{
    /**
     * @param string $path
     * @param bool $checkEmpty
     * @return bool
     */
    public function check(string $path, bool $checkEmpty): bool;
}
