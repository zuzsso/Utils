<?php

declare(strict_types=1);


namespace Utils\Files\Service;

use Utils\Files\UseCase\CheckDirectoryIsReadable;

class DirectoryIsReadableChecker implements CheckDirectoryIsReadable {
    public function check(string $dir): bool {
        return is_writable($dir);
    }
}
