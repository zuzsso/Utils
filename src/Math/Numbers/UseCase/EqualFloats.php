<?php

namespace Utils\Math\Numbers\UseCase;

interface EqualFloats {
    /**
     * @param float $f1
     * @param float $f2
     * @return bool
     */
    public function equalFloats(float $f1, float $f2): bool;
}
