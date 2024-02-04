<?php

declare(strict_types=1);

namespace Utils\Files\Type\FileExtension;

class Png extends AbstractFileExtension
{
    public static function getExtensionLiteralNoDot(): string
    {
        return 'png';
    }
}
