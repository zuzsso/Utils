<?php

declare(strict_types=1);


namespace Utils\System\Service;

use Utils\System\UseCase\CalculateSizeOfOnesComplementOfZero;

class SizeOfOnesComplementOfZero implements CalculateSizeOfOnesComplementOfZero {
    /**
     * @inheritDoc
     */
    public function calculate(): int {
        return strlen(decbin(~0));
    }
}
