<?php

declare(strict_types=1);

namespace Utils\System\Service;

use Utils\System\UseCase\GetPhpIntSizeConstant;

class PhpIntSizeConstantGetter implements GetPhpIntSizeConstant
{
    /**
     * @inheritDoc
     */
    public function get(): int
    {
        return PHP_INT_SIZE;
    }
}
