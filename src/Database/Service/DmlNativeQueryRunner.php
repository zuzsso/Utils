<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Doctrine\DBAL\Connection;
use Throwable;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\NamedParameterCollection;
use Utils\Database\UseCase\RunDmlNativeQuery;

class DmlNativeQueryRunner extends AbstractNativeQuery implements RunDmlNativeQuery
{
    /**
     * @inheritDoc
     */
    public function executeDml(
        Connection $connex,
        string $nativeSqlQuery,
        ?NamedParameterCollection $queryParameters
    ): void {
        try {
            $this->checkAllParametersInCollectionExistInQuery($nativeSqlQuery, $queryParameters);

            $stm = $connex->prepare($nativeSqlQuery);

            if ($queryParameters !== null) {
                $this->bindParameters($stm, $queryParameters);
            }

            $stm->executeQuery();
        } catch (Throwable $t) {
            throw new NativeQueryDbReaderUnmanagedException($t->getMessage(), $t->getCode(), $t);
        }
    }
}
