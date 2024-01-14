<?php

declare(strict_types=1);

namespace Utils\Language\Type\Language;

use Utils\Language\Exception\UnrecognizedLanguageException;

abstract class AbstractLanguage
{
    abstract public static function getApiLiteral(): string;

    abstract public static function getBcp47Code(): string;

    /**
     * @throws UnrecognizedLanguageException
     * @noinspection PhpUnused
     */
    final public static function constructFromApiLiteral(string $languageApiLiteral): self
    {
        switch ($languageApiLiteral) {
            case English::getApiLiteral():
                return new English();
            case Spanish::getApiLiteral():
                return new Spanish();
            case French::getApiLiteral():
                return new French();
            default:
                throw new UnrecognizedLanguageException("Language literal not recognized: $languageApiLiteral");
        }
    }

    /**
     * @throws UnrecognizedLanguageException
     * @noinspection PhpUnused
     */
    final public static function constructFromIso639Dash1Locale(string $languageIso639Dash1Locale): self
    {
        switch ($languageIso639Dash1Locale) {
            case English::getIso639Dash1Locale():
                return new English();
            case Spanish::getIso639Dash1Locale():
                return new Spanish();
            case French::getIso639Dash1Locale():
                return new French();
            default:
                throw new UnrecognizedLanguageException("Language literal not recognized: $languageIso639Dash1Locale");
        }
    }

    /** @noinspection PhpUnused */
    final public static function equalsTo(AbstractLanguage $anotherLanguage): bool
    {
        return static::getApiLiteral() === $anotherLanguage::getApiLiteral();
    }

    abstract public static function getIso639Dash1Locale(): string;

    abstract public function getPlainNameInSameLanguage(): string;
}
