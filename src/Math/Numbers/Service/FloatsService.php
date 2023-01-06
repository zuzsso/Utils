<?php

declare(strict_types=1);


namespace Utils\Math\Numbers\Service;

use Utils\Math\Numbers\UseCase\EqualFloats;

class FloatsService implements EqualFloats {
    /**
     * @inheritDoc
     */
    public function equalFloats(float $f1, float $f2): bool {
        return !(abs($f1 - $f2) > PHP_FLOAT_EPSILON);
    }
}
