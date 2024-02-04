<?php

declare(strict_types=1);

namespace Utils\Files\UseCase;

use Utils\Files\Exception\UnableToGenerateTemporaryFileException;
use Utils\Files\Type\FileExtension\AbstractFileExtension;

interface GenerateTemporaryFilename
{
    /**
     * @throws UnableToGenerateTemporaryFileException
     */
    public function randomNameWithExtensionAndGetFullPath(AbstractFileExtension $fileExtension): string;
}
