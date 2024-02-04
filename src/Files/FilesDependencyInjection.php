<?php

declare(strict_types=1);

namespace Utils\Files;

use Utils\AbstractDependencyInjection;
use Utils\Files\Service\DirectoryIsReadableChecker;
use Utils\Files\Service\DirectoryIsWriteableChecker;
use Utils\Files\Service\FileExistsChecker;
use Utils\Files\Service\FolderExistsEnsurer;
use Utils\Files\Service\SessionFilesCleaner;
use Utils\Files\Service\TemporaryFilenameGenerator;
use Utils\Files\UseCase\CheckDirectoryIsReadable;
use Utils\Files\UseCase\CheckDirectoryIsWriteable;
use Utils\Files\UseCase\CheckFileExists;
use Utils\Files\UseCase\CleanSessionFiles;
use Utils\Files\UseCase\EnsureFolderExists;
use Utils\Files\UseCase\GenerateTemporaryFilename;

use function DI\autowire;

class FilesDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            CleanSessionFiles::class => autowire(SessionFilesCleaner::class),
            CheckDirectoryIsReadable::class => autowire(DirectoryIsReadableChecker::class),
            CheckDirectoryIsWriteable::class => autowire(DirectoryIsWriteableChecker::class),
            CheckFileExists::class => autowire(FileExistsChecker::class),
            EnsureFolderExists::class => autowire(FolderExistsEnsurer::class),
            GenerateTemporaryFilename::class => autowire(TemporaryFilenameGenerator::class)
        ];
    }
}
