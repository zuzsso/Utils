<?php

declare(strict_types=1);

namespace Utils\Files\Service;

use Utils\Files\UseCase\CheckFileExists;

class FileExistsChecker implements CheckFileExists
{
    /**
     * @inheritDoc
     */
    public function check(string $path, bool $checkEmpty = false): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        if (!is_file($path)) {
            return false;
        }

        if (!$checkEmpty) {
            return true;
        }

        $filesize = filesize($path);

        return !(($filesize === false) || ($filesize === 0));
    }
}
