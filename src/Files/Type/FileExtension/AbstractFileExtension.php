<?php

declare(strict_types=1);

namespace Utils\Files\Type\FileExtension;

use Utils\Files\Exception\UnrecognizedImageExtensionException;

abstract class AbstractFileExtension {

    abstract public static function getExtensionLiteralNoDot(): string;

    /**
     * @throws UnrecognizedImageExtensionException
     */
    public static function constructFromExtensionLiteralNoDot(string $extensionLiteral): self {
        $lowered = strtolower(trim($extensionLiteral));

        switch ($lowered) {
            case Png::getExtensionLiteralNoDot():
                return new Png();
            case Jpg::getExtensionLiteralNoDot():
                return new Jpg();
            default:
                throw new UnrecognizedImageExtensionException();
        }
    }
}
