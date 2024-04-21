<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;
use Utils\Database\Type\NamedParameterCollection;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;

/**
 * @deprecated
 * See zuzsso/database
 */
abstract class AbstractNativeQueryRunner
{
    /**
     * @deprecated
     * See zuzsso/database
     */
    protected ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery;

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function __construct(ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery)
    {
        $this->extractParameterNamesFromRawQuery = $extractParameterNamesFromRawQuery;
    }

    /**
     * @deprecated
     * See zuzsso/database
     * @throws Exception
     */
    protected function bindParameters(Statement $stm, NamedParameterCollection $queryParameters): void
    {
        foreach ($queryParameters as $parameterName => $parameterValue) {
            // Parameter value as string by default
            $stm->bindValue($parameterName, $parameterValue);
        }
    }
}
