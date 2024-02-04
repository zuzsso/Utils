<?php

declare(strict_types=1);

namespace Utils\Files\Service;

use Utils\Files\Exception\UnableToGenerateTemporaryFileException;
use Utils\Files\Type\FileExtension\AbstractFileExtension;
use Utils\Files\Type\TemporaryFileName;
use Utils\Files\UseCase\CheckFileExists;
use Utils\Files\UseCase\GenerateTemporaryFilename;

class TemporaryFilenameGenerator implements GenerateTemporaryFilename
{
    private CheckFileExists $checkFileExists;

    public function __construct(CheckFileExists $checkFileExists)
    {
        $this->checkFileExists = $checkFileExists;
    }

    /**
     * @inheritDoc
     */
    public function randomNameWithExtensionAndGetFullPath(AbstractFileExtension $fileExtension): string
    {

        $tmpFolder = sys_get_temp_dir();

        $success = false;
        $currentAttempt = 0;
        $maxAttempts = 10;

        do {

            $tmpFileName = new TemporaryFileName();

            $fullPath =
                $tmpFolder .
                '/' .
                $tmpFileName->getCryptokenAsString() .
                '.' .
                $fileExtension::getExtensionLiteralNoDot();

            if (!$this->checkFileExists->check($fullPath, false)) {
                $success = true;
            }

            $currentAttempt++;
        } while (!(($success === true) || ($currentAttempt > $maxAttempts)));

        if ($success === false) {
            throw new UnableToGenerateTemporaryFileException("Reached max attempts");
        }

        return $fullPath;
    }
}
