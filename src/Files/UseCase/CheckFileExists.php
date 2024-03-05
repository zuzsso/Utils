<?php

namespace Utils\Files\UseCase;

interface CheckFileExists
{
    /**
     * Checks whether the file exists or not
     *
     * If $checkEmpty is set to 'true', then the function will return 'false' even if the file exists but has no content
     */
    public function check(string $path, bool $checkEmpty): bool;
}
