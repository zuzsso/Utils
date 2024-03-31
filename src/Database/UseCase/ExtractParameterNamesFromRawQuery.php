<?php

declare(strict_types=1);

namespace Utils\Database\UseCase;

interface ExtractParameterNamesFromRawQuery
{
    public function extract(string $sqlQuery): array;
}
