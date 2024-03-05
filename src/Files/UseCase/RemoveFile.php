<?php

declare(strict_types=1);

namespace Utils\Files\UseCase;

use Utils\Files\Exception\FileRemoverUnmanagedException;

interface RemoveFile
{
    /**
     * @throws FileRemoverUnmanagedException
     */
    public function removeFileFromFullUrl(string $fullPath): void;
}
