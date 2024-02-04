<?php

declare(strict_types=1);

namespace Utils\Files\Service;

use Utils\Files\Exception\UnableToCreateFolderException;
use Utils\Files\UseCase\EnsureFolderExists;

class FolderExistsEnsurer implements EnsureFolderExists
{
    /**
     * @inheritDoc
     */
    public function ensureFolderExists(string $folderPath, int $createWithPermissions = 0770): void
    {
        if (
            !file_exists($folderPath) &&
            !mkdir($concurrentDirectory = $folderPath, $createWithPermissions, true) &&
            !is_dir($concurrentDirectory)
        ) {
            throw new UnableToCreateFolderException("Could not create folder: $folderPath");
        }
    }

    /**
     * @inheritDoc
     */
    public function ensureFolderExistsForFile(string $filePath, int $createWithPermissions = 0770): string
    {

        $folderName = dirname($filePath);
        $this->ensureFolderExists($folderName, $createWithPermissions);

        return $folderName;
    }
}
