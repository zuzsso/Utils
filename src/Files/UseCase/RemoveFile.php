<?php

declare(strict_types=1);

namespace Utils\Files\UseCase;

interface RemoveFile
{
    public function removeFileFromFullUrl(string $fullUrl): void;
}
