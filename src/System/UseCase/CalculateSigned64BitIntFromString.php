<?php

declare(strict_types=1);

namespace Utils\System\UseCase;

interface CalculateSigned64BitIntFromString
{
    /**
     * @return int
     */
    public function calculate(): int;
}
