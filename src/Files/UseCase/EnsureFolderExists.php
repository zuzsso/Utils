<?php

declare(strict_types=1);

namespace Utils\Files\UseCase;

use Utils\Files\Exception\UnableToCreateFolderException;

interface EnsureFolderExists {
    /**
     * Will check whether the folder passed as parameter exists. If it exists, it won't make any changes. If it does not,
     * then it will try to create it (recursively), with the permissions passed as parameter
     * @param string $folderPath
     * @param int $createWithPermissions
     * @throws UnableToCreateFolderException
     */
    public function ensureFolderExists(string $folderPath, int $createWithPermissions): void;
}
