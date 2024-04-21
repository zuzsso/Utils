<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Database\Exception\UnconstructibleRawSqlQueryException;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;

/**
 * @deprecated
 * See zuzsso/database
 *
 * This class only checks that the raw string only contains one query (e.g. no ';' included), and that it is correctly
 * parametrized in the way PDO libraries expect to see when binding parameters.
 *
 * We call it $rawSql, but in fact it is a raw string. It won't check for syntax, nor should it. For that, you need to
 * inject a service that does so, but that can also be done when the query is executed.
 */
class NativeSelectSqlQuery extends AbstractSqlNativeQuery
{
    /**
     * @deprecated
     * See zuzsso/database
     * @throws UnconstructibleRawSqlQueryException
     */
    public function __construct(
        ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery,
        string $rawSql,
        ?NamedParameterCollection $queryParams
    ) {
        parent::__construct($extractParameterNamesFromRawQuery, $rawSql, $queryParams);

        $aux = strtolower(trim($rawSql));

        if (!str_starts_with($aux, 'select')) {
            throw new UnconstructibleRawSqlQueryException('Only SELECT query types allowed');
        }
    }
}
