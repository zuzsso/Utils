<?php

declare(strict_types=1);

namespace Utils\Math;

use Utils\AbstractDependencyInjection;
use Utils\Math\Numbers\Service\FloatsService;
use Utils\Math\Numbers\Service\StringRepresentsIntegerValueChecker;
use Utils\Math\Numbers\UseCase\CheckStringRepresentsIntegerValue;
use Utils\Math\Numbers\UseCase\EqualFloats;
use function DI\autowire;

class MathDependencyInjection extends AbstractDependencyInjection {
    public static function getDependencies(): array {
        return [
            CheckStringRepresentsIntegerValue::class => autowire(StringRepresentsIntegerValueChecker::class),
            EqualFloats::class => autowire(FloatsService::class)
        ];
    }
}
