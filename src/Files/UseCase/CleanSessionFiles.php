<?php

declare(strict_types=1);

namespace Utils\Files\UseCase;

interface CleanSessionFiles
{
    public function addFileToClean(string $fileFullPath): void;

    public function cleanAllListed(): void;
}
