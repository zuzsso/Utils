<?php

declare(strict_types=1);

namespace Utils\Language\Type\Language;

class Spanish extends AbstractLanguage
{
    final public static function getBcp47Code(): string
    {
        return 'es-ES';
    }

    final public static function getApiLiteral(): string
    {
        return 'es-ES';
    }

    final public static function getIso639Dash1Locale(): string
    {
        return 'es';
    }

    final public function getPlainNameInSameLanguage(): string
    {
        return 'Español';
    }
}
