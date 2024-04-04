<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\NamedParameterCollection;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;

abstract class AbstractNativeQuery
{
    protected ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery;

    public function __construct(ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery)
    {
        $this->extractParameterNamesFromRawQuery = $extractParameterNamesFromRawQuery;
    }

    /**
     * @throws Exception
     */
    protected function bindParameters(Statement $stm, NamedParameterCollection $queryParameters): void
    {
        foreach ($queryParameters as $parameterName => $parameterValue) {
            // Parameter value as string by default
            $stm->bindValue($parameterName, $parameterValue);
        }
    }

    /**
     * @throws NativeQueryDbReaderUnmanagedException
     */
    protected function checkAllParametersInCollectionExistInQuery(
        string $nativeSqlQuery,
        ?NamedParameterCollection $queryParameters
    ): void {
        $extractedParameters = $this->extractParameterNamesFromRawQuery->extract($nativeSqlQuery);


        $extractedParametersCount = count($extractedParameters);

        $collectionCount = 0;
        if ($queryParameters !== null) {
            $collectionCount = $queryParameters->count();
        }

        if (($collectionCount === 0) && ($extractedParametersCount === 0)) {
            return;
        }

        foreach ($extractedParameters as $extractedParameter) {
            if (!$queryParameters->hasParameter($extractedParameter)) {
                throw new NativeQueryDbReaderUnmanagedException("Placeholder ':$extractedParameter' is not bound");
            }
        }

        foreach ($queryParameters as $parameterName => $parameterValue) {
            if (!in_array($parameterName, $extractedParameters, true)) {
                throw new NativeQueryDbReaderUnmanagedException("Placeholder ':$parameterName' not found in raw query");
            }
        }
    }
}
