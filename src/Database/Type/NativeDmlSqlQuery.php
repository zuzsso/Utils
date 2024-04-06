<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Database\Exception\UnconstructibleRawSqlQueryException;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;

use function PHPUnit\Framework\stringStartsWith;

class NativeDmlSqlQuery extends AbstractSqlNativeQuery
{
    public function __construct(
        ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery,
        string $rawSql,
        ?NamedParameterCollection $queryParams
    ) {
        parent::__construct($extractParameterNamesFromRawQuery, $rawSql, $queryParams);

        $keywords = [
            'update',
            'delete',
            'create',
            'drop',
            'alter'
        ];

        $aux = strtolower(trim($rawSql));
        $pass = false;

        foreach ($keywords as $k) {
            if (str_starts_with($aux, $k)) {
                $pass = true;
                break;
            }
        }

        if (!$pass) {
            throw new UnconstructibleRawSqlQueryException(
                "Only the following types are allowed: " . implode(', ', $keywords)
            );
        }
    }
}
