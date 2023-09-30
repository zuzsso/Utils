<?php

declare(strict_types=1);

namespace Utils\Files\Service;

use Utils\Files\UseCase\CleanSessionFiles;

class SessionFilesCleaner implements CleanSessionFiles {
    /** @var string[] */
    private array $listOfFilesToClean = [];

    public function addFileToClean(string $fileFullPath): void {
        $this->listOfFilesToClean[] = $fileFullPath;
    }

    public function cleanAllListed(): void {
        foreach($this->listOfFilesToClean as $path) {
            unlink($path);
        }
    }
}
