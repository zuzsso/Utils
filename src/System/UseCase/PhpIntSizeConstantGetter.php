<?php

declare(strict_types=1);


namespace Utils\System\UseCase;

use Utils\System\Service\GetPhpIntSizeConstant;

class PhpIntSizeConstantGetter implements GetPhpIntSizeConstant {

    /**
     * @inheritDoc
     */
    public function get(): int {
        return PHP_INT_SIZE;
    }
}
