<?php

declare(strict_types=1);


namespace Utils\Math\Numbers\UseCase;

interface CheckStringRepresentsIntegerValue {
    public function checkPositiveOrZero(string $s): bool;
    public static function checkPositiveOrZeroStatic(string $s): bool;
}
