<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Doctrine\DBAL\Connection;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\ParameterCollection;

interface ReadDbNativeQuery
{
    /**
     * @throws NativeQueryDbReaderUnmanagedException
     */
    public function getAllRawRecords(
        Connection $connex,
        string $nativeSqlQuery,
        ParameterCollection $queryParameters
    ): array;
}
