<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Doctrine\DBAL\Connection;
use Utils\Database\Exception\DmlNativeQueryRunnerUnmanagedException;
use Utils\Database\Type\NativeDmlSqlQuery;

interface RunDmlNativeQuery
{
    /**
     * @throws DmlNativeQueryRunnerUnmanagedException
     */
    public function executeDml(
        Connection $connex,
        NativeDmlSqlQuery $query
    ): void;
}
