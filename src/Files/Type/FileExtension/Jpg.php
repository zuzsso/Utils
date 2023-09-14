<?php

declare(strict_types=1);

namespace Utils\Files\Type\FileExtension;

class Jpg extends AbstractFileExtension {

    public static function getExtensionLiteralNoDot(): string {
        return 'jpg';
    }
}
