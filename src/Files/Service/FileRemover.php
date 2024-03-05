<?php

declare(strict_types=1);

namespace Utils\Files\Service;

use Utils\Files\Exception\FileRemoverUnmanagedException;
use Utils\Files\UseCase\CheckFileExists;
use Utils\Files\UseCase\RemoveFile;

class FileRemover implements RemoveFile
{
    private const MAX_DELETE_ATTEMPTS = 5;

    private CheckFileExists $checkFileExists;

    public function __construct(CheckFileExists $checkFileExists)
    {
        $this->checkFileExists = $checkFileExists;
    }

    /**
     * @inheritDoc
     */
    public function removeFileFromFullUrl(string $fullPath): void
    {
        $exists = $this->checkFileExists->check($fullPath, true);

        if (!$exists) {
            return;
        }

        for ($i = 0; $i < self::MAX_DELETE_ATTEMPTS; $i++) {
            unlink($fullPath);

            if ($this->checkFileExists->check($fullPath, true)) {
                usleep(300000); // 0.3 secs
            } else {
                return;
            }
        }

        throw new FileRemoverUnmanagedException(
            "Could not remove '$fullPath' after " . self::MAX_DELETE_ATTEMPTS . " attempts"
        );
    }
}
