<?php

declare(strict_types=1);

namespace Utils\Math\Numbers\Service;

use Utils\Math\Numbers\UseCase\CheckStringRepresentsIntegerValue;

class StringRepresentsIntegerValueChecker implements CheckStringRepresentsIntegerValue {
    public function checkPositiveOrZero(string $s): bool {
        return self::checkPositiveOrZeroStatic($s);
    }

    public static function checkPositiveOrZeroStatic(string $s): bool {
        return preg_match("/^\d+$/", $s) === 1;
    }
}
