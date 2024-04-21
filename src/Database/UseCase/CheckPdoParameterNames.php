<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

/**
 * @deprecated
 * See zuzsso/database
 */
interface CheckPdoParameterNames
{
    /**
     * @deprecated
     * See zuzsso/database
     */
    public function getPdoPlaceholderRegex(): string;

    /**
     * @deprecated
     * See zuzsso/database
     */
    public function checkStringRepresentsParameterName(string $parameterName): bool;
}
