<?php

declare(strict_types=1);


namespace Utils\Files\Service;

use Utils\Files\Exception\UnableToCreateFolderException;
use Utils\Files\UseCase\EnsureFolderExists;

class FolderExistsEnsurer implements EnsureFolderExists {
    /**
     * @inheritDoc
     */
    public function ensureFolderExists(string $folderPath, int $createWithPermissions): void {
        if (
            !file_exists($folderPath) &&
            !mkdir($concurrentDirectory = $folderPath, 0770) &&
            !is_dir($concurrentDirectory)
        ) {
            throw new UnableToCreateFolderException("Could not create folder: $folderPath");
        }
    }
}
