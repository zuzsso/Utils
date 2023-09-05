<?php

declare(strict_types=1);


namespace Utils\System\UseCase;

interface GetPhpIntSizeConstant {
    /**
     * @return int
     */
    public function get(): int;
}
