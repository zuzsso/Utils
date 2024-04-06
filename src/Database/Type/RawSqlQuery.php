<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Exception\UnconstructibleRawSqlQueryException;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;

/**
 * This class only checks that the raw string only contains one query (e.g. no ';' included), and that it is correctly
 * parametrized in the way PDO libraries expect to see when binding parameters.
 *
 * We call it $rawSql, but in fact it is a raw string. It won't check for syntax, nor should it. For that, you need to
 * inject a service that does so, but that can also be done when the query is executed.
 */
class RawSqlQuery
{
    private ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery;

    private string $rawSql;

    private ?NamedParameterCollection $queryParams;

    /**
     * @throws UnconstructibleRawSqlQueryException
     */
    public function __construct(
        ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery,
        string $rawSql,
        ?NamedParameterCollection $queryParams
    ) {
        $this->extractParameterNamesFromRawQuery = $extractParameterNamesFromRawQuery;
        $this->rawSql = $rawSql;
        $this->queryParams = $queryParams;

        if (strpos($rawSql, ';') !== false) {
            throw new UnconstructibleRawSqlQueryException("Found ';' in the raw text. Multiple queries not allowed");
        }

        try {
            $this->checkAllParametersInCollectionExistInQuery();
        } catch (NativeQueryDbReaderUnmanagedException $e) {
            throw new UnconstructibleRawSqlQueryException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getRawSql(): string
    {
        return $this->rawSql;
    }

    public function getParams(): ?NamedParameterCollection
    {
        return $this->queryParams;
    }

    /**
     * @throws NativeQueryDbReaderUnmanagedException
     */
    private function checkAllParametersInCollectionExistInQuery(): void
    {
        $extractedParameters = $this->extractParameterNamesFromRawQuery->extract($this->rawSql);

        $extractedParametersCount = count($extractedParameters);

        $collectionCount = 0;
        if ($this->queryParams !== null) {
            $collectionCount = $this->queryParams->count();
        }

        if (($collectionCount === 0) && ($extractedParametersCount === 0)) {
            return;
        }

        if ($collectionCount !== $extractedParametersCount) {
            throw new NativeQueryDbReaderUnmanagedException(
                "Found $extractedParametersCount parameters to be bound in the raw query, but the collection has $collectionCount. Make sure that placeholders in the raw query are prefixed with ':' "
            );
        }

        foreach ($extractedParameters as $extractedParameter) {
            if (!$this->queryParams->hasParameter($extractedParameter)) {
                throw new NativeQueryDbReaderUnmanagedException(
                    "Found placeholder ':$extractedParameter' in the raw query but the collection doesn't have '$extractedParameter'. Make sure you call \$myCollection->add(...,':$extractedParameter', 'your value')"
                );
            }
        }
    }
}
