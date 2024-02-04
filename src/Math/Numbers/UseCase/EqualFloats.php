<?php

namespace Utils\Math\Numbers\UseCase;

interface EqualFloats
{
    public function equalFloats(float $f1, float $f2, float $maxDifference = 0.000000001): bool;
}
