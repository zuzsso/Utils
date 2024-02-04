<?php

declare(strict_types=1);

namespace Utils\DateAndTime;

use Utils\AbstractDependencyInjection;
use Utils\DateAndTime\Service\DateTimeComparator;
use Utils\DateAndTime\Service\DateTimeFormatter;
use Utils\DateAndTime\Service\DateTimeProvider;
use Utils\DateAndTime\Service\DateTimeSerializer;
use Utils\DateAndTime\Service\DateTimeTransformer;
use Utils\DateAndTime\UseCase\CompareDateTime;
use Utils\DateAndTime\UseCase\FormatDateTime;
use Utils\DateAndTime\UseCase\ProvideDateTime;
use Utils\DateAndTime\UseCase\SerializeDateTime;
use Utils\DateAndTime\UseCase\TransformDateTime;

use function DI\autowire;

class DateAndTimeDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            CompareDateTime::class => autowire(DateTimeComparator::class),
            FormatDateTime::class => autowire(DateTimeFormatter::class),
            ProvideDateTime::class => autowire(DateTimeProvider::class),
            TransformDateTime::class => autowire(DateTimeTransformer::class),
            SerializeDateTime::class => autowire(DateTimeSerializer::class),
        ];
    }
}
