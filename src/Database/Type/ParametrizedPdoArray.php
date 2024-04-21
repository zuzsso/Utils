<?php

declare(strict_types=1);

namespace Utils\Database\Type;

use Utils\Database\Exception\ParametrizedPdoArrayException;

/**
 * @deprecated
 * See zuzsso/database
 */
class ParametrizedPdoArray
{
    /**
     * @deprecated
     * See zuzsso/database
     */
    private array $parameterNames = [];
    /**
     * @deprecated
     * See zuzsso/database
     */
    private array $parameterAssociation = [];

    /**
     * @deprecated
     * See zuzsso/database
     * @throws ParametrizedPdoArrayException
     * @noinspection PhpUnused
     */
    public function addParameter(string $parameterName, string $parameterValue): void
    {
        $sanitizedParameterName = trim($parameterName);

        if ($sanitizedParameterName === '') {
            throw new ParametrizedPdoArrayException('Empty parameter name');
        }

        if (str_starts_with($sanitizedParameterName, ':')) {
            throw new ParametrizedPdoArrayException('Parameter name cannot start with colon');
        }

        if (in_array($parameterName, $this->parameterNames, true)) {
            throw new ParametrizedPdoArrayException("Duplicated parameter: $parameterName");
        }

        $sanitizedParameterValue = trim($parameterValue);

        if ($sanitizedParameterValue === '') {
            throw new ParametrizedPdoArrayException('Parameter value is empty string');
        }

        $this->parameterNames[] = $sanitizedParameterName;
        $this->parameterAssociation[$parameterName] = $parameterValue;
    }

    /**
     * @deprecated
     * See zuzsso/database
     * @throws ParametrizedPdoArrayException
     */
    public function getParameterNames(): array
    {
        if (count($this->parameterNames) === 0) {
            throw new ParametrizedPdoArrayException('No parameters');
        }

        return array_map(static function (string $parameterName): string {
            return ':' . $parameterName;
        }, $this->parameterNames);
    }

    /**
     * @deprecated
     * See zuzsso/database
     * @throws ParametrizedPdoArrayException
     * @noinspection PhpUnused
     */
    public function getParameterNamesAsString(): string
    {
        $names = $this->getParameterNames();

        return implode(',', $names);
    }

    /**
     * @deprecated
     * See zuzsso/database
     * @throws ParametrizedPdoArrayException
     * @noinspection PhpUnused
     */
    public function getParameterAssociation(): array
    {
        if (count($this->parameterAssociation) === 0) {
            throw new ParametrizedPdoArrayException('No parameters');
        }

        return $this->parameterAssociation;
    }
}
