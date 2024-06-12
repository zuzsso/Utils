<?php

declare(strict_types=1);

namespace Utils\Language\Type\Language;

/**
 * @deprecated
 * migrated to its own repo
 */
class English extends AbstractLanguage
{
    /**
     * @deprecated
     * migrated to its own repo
     */
    final public static function getBcp47Code(): string
    {
        return 'en-GB';
    }

    /**
     * @deprecated
     * migrated to its own repo
     */
    final public static function getApiLiteral(): string
    {
        return 'en-GB';
    }

    /**
     * @deprecated
     * migrated to its own repo
     */
    final public static function getIso639Dash1Locale(): string
    {
        return 'en';
    }

    /**
     * @deprecated
     * migrated to its own repo
     */
    final public function getPlainNameInSameLanguage(): string
    {
        return 'English';
    }
}
