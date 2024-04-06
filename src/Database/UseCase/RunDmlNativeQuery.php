<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Doctrine\DBAL\Connection;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\RawSqlQuery;

interface RunDmlNativeQuery
{
    /**
     * @throws NativeQueryDbReaderUnmanagedException
     */
    public function executeDml(
        Connection $connex,
        RawSqlQuery $query
    ): void;
}
