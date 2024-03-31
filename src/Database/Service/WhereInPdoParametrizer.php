<?php

declare(strict_types=1);

namespace Utils\Database\Service;


use Utils\Database\Exception\NativeQueryDbReaderUnmanagedException;
use Utils\Database\Type\ParametrizedPdoArray;
use Utils\Database\UseCase\CheckPdoParameterNames;
use Utils\Database\UseCase\ParametrizeWhereInPdo;

class WhereInPdoParametrizer implements ParametrizeWhereInPdo
{
    private CheckPdoParameterNames $checkPdoParameterNames;

    public function __construct(CheckPdoParameterNames $checkPdoParameterNames)
    {
        $this->checkPdoParameterNames = $checkPdoParameterNames;
    }

    /**
     * @inheritDoc
     */
    public function parametrize(string $prefix, array $values): ParametrizedPdoArray
    {
        if (!$this->checkPdoParameterNames->checkStringRepresentsParameterName($prefix)) {
            throw new NativeQueryDbReaderUnmanagedException(
                "Prefix '$prefix' doesn't seem to be a valid name for a PDO parameter"
            );
        }

        $counter = 0;

        $result = new ParametrizedPdoArray();

        foreach ($values as $v) {
            $thisParameterName = "${prefix}_$counter";
            $result->addParameter($thisParameterName, $v);

            $counter++;
        }

        return $result;
    }
}
