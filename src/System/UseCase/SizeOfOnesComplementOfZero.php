<?php

declare(strict_types=1);


namespace Utils\System\UseCase;

use Utils\System\Service\CalculateSizeOfOnesComplementOfZero;

class SizeOfOnesComplementOfZero implements CalculateSizeOfOnesComplementOfZero {
    /**
     * @inheritDoc
     */
    public function calculate(): int {
        return strlen(decbin(~0));
    }
}
