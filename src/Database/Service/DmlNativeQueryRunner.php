<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Doctrine\DBAL\Connection;
use Throwable;
use Utils\Database\Exception\DmlNativeQueryRunnerUnmanagedException;
use Utils\Database\Type\NativeDmlSqlQuery;
use Utils\Database\UseCase\RunDmlNativeQuery;

/**
 * @deprecated
 * See zuzsso/database
 */
class DmlNativeQueryRunner extends AbstractNativeQueryRunner implements RunDmlNativeQuery
{
    /**
     * @deprecated
     * See zuzsso/database
     * @inheritDoc
     */
    public function executeDml(
        Connection $connex,
        NativeDmlSqlQuery $query
    ): void {
        try {

            $stm = $connex->prepare($query->getRawSql());

            if ($query->getParams() !== null) {
                $this->bindParameters($stm, $query->getParams());
            }

            $stm->executeQuery();
        } catch (Throwable $t) {
            throw new DmlNativeQueryRunnerUnmanagedException($t->getMessage(), $t->getCode(), $t);
        }
    }
}
