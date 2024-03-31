<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Doctrine\DBAL\Connection;
use Throwable;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\ParameterCollection;
use Utils\Database\UseCase\ReadDbNativeQuery;

class NativeQueryDbReader implements ReadDbNativeQuery
{
    /**
     * @inheritDoc
     */
    public function getAllRecords(
        Connection $connex,
        string $nativeSqlQuery,
        ParameterCollection $queryParameters
    ): array {
        try {
            $stm = $connex->prepare($nativeSqlQuery);

            foreach ($queryParameters as $parameterName => $parameterValue) {
                // We should find that parameter name in the native query
                if (strpos(':' . $parameterName, $nativeSqlQuery) === false) {
                    throw new NativeQueryDbReaderUnmanagedException("Parameter '$parameterName' not found in query");
                }

                // Parameter value as string by default
                $stm->bindValue($parameterName, $parameterValue);
            }

            /** @noinspection OneTimeUseVariablesInspection */
            $result = $stm->executeQuery();

            return $result->fetchAllAssociative();
        } catch (Throwable $t) {
            throw new NativeQueryDbReaderUnmanagedException($t->getMessage(), $t->getCode(), $t);
        }
    }
}
