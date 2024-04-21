<?php

declare(strict_types=1);

namespace Utils\Math\Numbers\Service;

use Utils\Math\Numbers\UseCase\CheckStringRepresentsIntegerValue;

/**
 * @deprecated
 * Migrated to zuzsso/math
 */
class StringRepresentsIntegerValueChecker implements CheckStringRepresentsIntegerValue
{
    /**
     * @deprecated
     * Migrated to zuzsso/math
     */
    public function checkPositiveOrZero(string $s): bool
    {
        return self::checkPositiveOrZeroStatic($s);
    }

    /**
     * @deprecated
     * Migrated to zuzsso/math
     */
    public static function checkPositiveOrZeroStatic(string $s): bool
    {
        return preg_match("/^\d+$/", $s) === 1;
    }
}
