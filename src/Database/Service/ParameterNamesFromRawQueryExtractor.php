<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Utils\Database\UseCase\CheckPdoParameterNames;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;

/**
 * @deprecated
 * See zuzsso/database
 */
class ParameterNamesFromRawQueryExtractor implements ExtractParameterNamesFromRawQuery
{
    /**
     * @deprecated
     * See zuzsso/database
     */
    private CheckPdoParameterNames $checkPdoParameterNames;

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function __construct(CheckPdoParameterNames $checkPdoParameterNames)
    {
        $this->checkPdoParameterNames = $checkPdoParameterNames;
    }

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function extract(string $sqlQuery): array
    {
        $regex = $this->checkPdoParameterNames->getPdoPlaceholderRegex();

        preg_match_all($regex, $sqlQuery, $matches);

        $result = [];

        if (count($matches) > 0) {
            $occurrences = $matches[0];

            foreach ($occurrences as $parameterName) {
                $result[] = $parameterName;
            }
        }

        return ($result);
    }
}
