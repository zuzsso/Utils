<?php

declare(strict_types=1);

namespace Utils\System\Service;

use Utils\System\UseCase\CalculateSigned64BitIntFromString;
use Utils\System\UseCase\CalculateSizeOfOnesComplementOfZero;
use Utils\System\UseCase\CheckSystem64Bits;
use Utils\System\UseCase\GetOSDescription;
use Utils\System\UseCase\GetPhpIntSizeConstant;

class System64BitChecker implements CheckSystem64Bits
{
    private GetPhpIntSizeConstant $getPhpIntSizeConstant;
    private CalculateSizeOfOnesComplementOfZero $calculateSizeOfOnesComplementOfZero;
    private GetOSDescription $getOSDescription;
    private CalculateSigned64BitIntFromString $calculateSigned64BitIntFromString;

    public function __construct(
        GetPhpIntSizeConstant $getPhpIntSizeConstant,
        CalculateSizeOfOnesComplementOfZero $calculateSizeOfOnesComplementOfZero,
        GetOSDescription $getOSDescription,
        CalculateSigned64BitIntFromString $calculateSigned64BitIntFromString
    ) {
        $this->getPhpIntSizeConstant = $getPhpIntSizeConstant;
        $this->calculateSizeOfOnesComplementOfZero = $calculateSizeOfOnesComplementOfZero;
        $this->getOSDescription = $getOSDescription;
        $this->calculateSigned64BitIntFromString = $calculateSigned64BitIntFromString;
    }

    /**
     * @inheritDoc
     */
    public function is64Bits(): bool
    {
        $strategy01 = $this->getPhpIntSizeConstant->get() === 8;
        $strategy02 = $this->calculateSizeOfOnesComplementOfZero->calculate() === 64;
        $strategy03 = strpos($this->getOSDescription->get(), '64') !== false;
        $strategy04 = $this->calculateSigned64BitIntFromString->calculate() === 9223372036854775807;

        return $strategy01 && $strategy02 && $strategy03 && $strategy04;
    }
}
