<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Exception\ParametrizedPdoArrayException;
use Utils\Database\Type\ParametrizedPdoArray;

interface ParametrizeWhereInPdo
{
    /**
     * @throws ParametrizedPdoArrayException
     * @throws NativeQueryDbReaderUnmanagedException
     */
    public function parametrize(string $prefix, array $values): ParametrizedPdoArray;
}
