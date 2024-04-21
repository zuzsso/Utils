<?php

namespace Utils\Math\Numbers\UseCase;

/**
 * @deprecated
 * Migrated to zuzsso/math
 */
interface EqualFloats
{
    /**
     * @deprecated
     * Migrated to zuzsso/math
     * Compares two floats using the Epsilon technique
     */
    public function equalFloats(float $f1, float $f2, float $maxDifference = PHP_FLOAT_EPSILON): bool;
}
