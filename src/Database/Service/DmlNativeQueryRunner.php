<?php

declare(strict_types=1);

namespace Utils\Database\Service;

use Doctrine\DBAL\Connection;
use Throwable;
use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\RawSqlQuery;
use Utils\Database\UseCase\RunDmlNativeQuery;

class DmlNativeQueryRunner extends AbstractNativeQuery implements RunDmlNativeQuery
{
    /**
     * @inheritDoc
     */
    public function executeDml(
        Connection $connex,
        RawSqlQuery $query
    ): void {
        try {

            $stm = $connex->prepare($query->getRawSql());

            if ($query->getParams() !== null) {
                $this->bindParameters($stm, $query->getParams());
            }

            $stm->executeQuery();
        } catch (Throwable $t) {
            throw new NativeQueryDbReaderUnmanagedException($t->getMessage(), $t->getCode(), $t);
        }
    }
}
