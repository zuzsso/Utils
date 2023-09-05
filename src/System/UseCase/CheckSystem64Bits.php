<?php

namespace Utils\System\UseCase;

interface CheckSystem64Bits {
    /**
     * @return bool
     */
    public function is64Bits(): bool;
}
