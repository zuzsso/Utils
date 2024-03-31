<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Doctrine\DBAL\Connection;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\NamedParameterCollection;

interface ReadDbNativeQuery
{
    /**
     * @throws NativeQueryDbReaderUnmanagedException
     */
    public function getAllRawRecords(
        Connection $connex,
        string $nativeSqlQuery,
        ?NamedParameterCollection $queryParameters
    ): array;
}
