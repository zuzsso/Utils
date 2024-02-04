<?php

declare(strict_types=1);

namespace Utils;

abstract class AbstractDependencyInjection
{
    abstract public static function getDependencies(): array;
}
