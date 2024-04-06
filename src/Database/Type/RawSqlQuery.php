<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Database\Exception\UnconstructibleRawSqlQueryException;

class RawSqlQuery
{
    private string $rawSql;
    private array $params;

    /**
     * @throws UnconstructibleRawSqlQueryException
     */
    public function __construct(string $rawSql, array $pdoStyleQueryParams = [])
    {
        $this->rawSql = $rawSql;
        $this->params = $pdoStyleQueryParams;

        if (strpos($rawSql, ';') !== false) {
            throw new UnconstructibleRawSqlQueryException("Found ';' in the raw text. Multiple queries not allowed");
        }
    }

    public function getRawSql(): string
    {
        return $this->rawSql;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
