<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Doctrine\DBAL\Connection;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\NativeSelectSqlQuery;

interface ReadDbNativeQuery
{
    /**
     * @throws NativeQueryDbReaderUnmanagedException
     */
    public function getAllRawRecords(
        Connection $connex,
        NativeSelectSqlQuery $query
    ): array;
}
