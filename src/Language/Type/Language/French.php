<?php

declare(strict_types=1);

namespace Utils\Language\Type\Language;

class French extends AbstractLanguage
{
    final public static function getBcp47Code(): string
    {
        return 'fr-FR';
    }

    final public static function getApiLiteral(): string
    {
        return 'fr-FR';
    }

    final public static function getIso639Dash1Locale(): string
    {
        return 'fr';
    }

    final public function getPlainNameInSameLanguage(): string
    {
        return 'Français';
    }
}
