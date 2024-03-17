<?php

namespace Utils\Math\Numbers\UseCase;

interface EqualFloats
{
    /**
     * Compares two floats using the Epsilon technique
     */
    public function equalFloats(float $f1, float $f2, float $maxDifference = PHP_FLOAT_EPSILON): bool;
}
