<?php

declare(strict_types=1);


namespace Utils\System\Service;

use Utils\System\UseCase\CalculateSigned64BitIntFromString;

class Signed64BitIntFromStringCalculator implements CalculateSigned64BitIntFromString {
    /**
     * @inheritDoc
     */
    public function calculate(): int {
        /** @noinspection PhpCastIsEvaluableInspection */
        return (int)'9223372036854775807';
    }
}
