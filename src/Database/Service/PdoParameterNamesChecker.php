<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Utils\Database\UseCase\CheckPdoParameterNames;

/**
 * @deprecated
 * See zuzsso/database
 */
class PdoParameterNamesChecker implements CheckPdoParameterNames
{
    /**
     * @deprecated
     * See zuzsso/database
     */
    public function getPdoPlaceholderRegex(bool $anyPosition = true): string
    {
        $base = ':\w+';

        if ($anyPosition) {
            return "/$base/";
        }

        return "/^$base$/";
    }

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function checkStringRepresentsParameterName(string $parameterName): bool
    {
        preg_match_all($this->getPdoPlaceholderRegex(false), $parameterName, $matches);

        if (count($matches) === 0) {
            return false;
        }

        return count($matches[0]) === 1;
    }
}
