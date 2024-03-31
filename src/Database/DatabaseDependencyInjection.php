<?php

declare(strict_types=1);

namespace Utils\Database;

use Utils\AbstractDependencyInjection;
use Utils\Database\Service\NativeQueryDbReader;
use Utils\Database\UseCase\ReadDbNativeQuery;

use function DI\autowire;

class DatabaseDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            ReadDbNativeQuery::class => autowire(NativeQueryDbReader::class)
        ];
    }

}
