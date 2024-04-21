<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Exception\ParametrizedPdoArrayException;
use Utils\Database\Type\ParametrizedPdoArray;

/**
 * @deprecated
 * See zuzsso/database
 */
interface ParametrizeWhereInPdo
{
    /**
     * @deprecated
     * See zuzsso/database
     * @throws ParametrizedPdoArrayException
     * @throws NativeQueryDbReaderUnmanagedException
     */
    public function parametrize(string $prefix, array $values): ParametrizedPdoArray;
}
