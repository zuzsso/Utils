<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

interface CheckPdoParameterNames
{
    public function getPdoPlaceholderRegex(): string;

    public function checkStringRepresentsParameterName(string $parameterName): bool;
}
