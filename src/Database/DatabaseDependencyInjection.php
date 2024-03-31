<?php

declare(strict_types=1);

namespace Utils\Database;

use Utils\AbstractDependencyInjection;
use Utils\Database\Service\NativeQueryDbReader;
use Utils\Database\Service\ParameterNamesFromRawQueryExtractor;
use Utils\Database\Service\PdoParameterNamesChecker;
use Utils\Database\Service\WhereInPdoParametrizer;
use Utils\Database\UseCase\CheckPdoParameterNames;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;
use Utils\Database\UseCase\ParametrizeWhereInPdo;
use Utils\Database\UseCase\ReadDbNativeQuery;

use function DI\autowire;

class DatabaseDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            ParametrizeWhereInPdo::class => autowire(WhereInPdoParametrizer::class),
            CheckPdoParameterNames::class => autowire(PdoParameterNamesChecker::class),
            ExtractParameterNamesFromRawQuery::class => autowire(ParameterNamesFromRawQueryExtractor::class),
            ReadDbNativeQuery::class => autowire(NativeQueryDbReader::class)
        ];
    }

}
