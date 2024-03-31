<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Utils\Database\UseCase\CheckPdoParameterNames;

class PdoParameterNamesChecker implements CheckPdoParameterNames
{
    public function getPdoPlaceholderRegex(): string
    {
        return '/:\w+/';
    }

    public function checkStringRepresentsParameterName(string $parameterName): bool
    {
        preg_match_all('/^\w+$/', $parameterName, $matches);

        if (count($matches) === 0) {
            return false;
        }

        return count($matches[0]) === 1;
    }
}
