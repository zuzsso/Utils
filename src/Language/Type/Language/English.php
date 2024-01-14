<?php

declare(strict_types=1);

namespace Utils\Language\Type\Language;

class English extends AbstractLanguage
{
    final public static function getBcp47Code(): string
    {
        return 'en-GB';
    }

    final public static function getApiLiteral(): string
    {
        return 'en-GB';
    }

    final public static function getIso639Dash1Locale(): string
    {
        return 'en';
    }

    final public function getPlainNameInSameLanguage(): string
    {
        return 'English';
    }
}
