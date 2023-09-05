<?php

declare(strict_types=1);

namespace Utils\System;

use Utils\AbstractDependencyInjection;
use Utils\System\Service\OsDescriptionGetter;
use Utils\System\Service\PhpIntSizeConstantGetter;
use Utils\System\Service\Signed64BitIntFromStringCalculator;
use Utils\System\Service\SizeOfOnesComplementOfZero;
use Utils\System\Service\System64BitChecker;
use Utils\System\UseCase\CalculateSigned64BitIntFromString;
use Utils\System\UseCase\CalculateSizeOfOnesComplementOfZero;
use Utils\System\UseCase\CheckSystem64Bits;
use Utils\System\UseCase\GetOSDescription;
use Utils\System\UseCase\GetPhpIntSizeConstant;
use function DI\autowire;

class SystemDependencyInjection extends AbstractDependencyInjection {
    public static function getDependencies(): array {
        return [
            GetOSDescription::class => autowire(OsDescriptionGetter::class),
            GetPhpIntSizeConstant::class => autowire(PhpIntSizeConstantGetter::class),
            CalculateSigned64BitIntFromString::class => autowire(Signed64BitIntFromStringCalculator::class),
            CalculateSizeOfOnesComplementOfZero::class => autowire(SizeOfOnesComplementOfZero::class),
            CheckSystem64Bits::class => autowire(System64BitChecker::class),
        ];
    }
}
