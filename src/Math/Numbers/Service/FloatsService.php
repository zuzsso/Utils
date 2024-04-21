<?php

declare(strict_types=1);

namespace Utils\Math\Numbers\Service;

use Utils\Math\Numbers\UseCase\EqualFloats;

/**
 * @deprecated
 * Migrated to zuzsso/math
 */
class FloatsService implements EqualFloats
{
    /**
     * @deprecated
     * Migrated to zuzsso/math
     * @inheritDoc
     */
    public function equalFloats(float $f1, float $f2, float $maxDifference = 0.000000001): bool
    {
        return !(abs($f1 - $f2) > $maxDifference);
    }
}
