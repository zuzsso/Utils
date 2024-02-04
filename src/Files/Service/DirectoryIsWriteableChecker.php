<?php

declare(strict_types=1);

namespace Utils\Files\Service;

use Utils\Files\UseCase\CheckDirectoryIsWriteable;

class DirectoryIsWriteableChecker implements CheckDirectoryIsWriteable
{
    public function check(string $dir): bool
    {
        return is_writable($dir);
    }
}
