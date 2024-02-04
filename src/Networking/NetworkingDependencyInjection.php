<?php

declare(strict_types=1);

namespace Utils\Networking;

use Utils\AbstractDependencyInjection;
use Utils\Networking\Service\LocalHostIpV4Getter;
use Utils\Networking\UseCase\GetLocalHostIpV4;

use function DI\autowire;

class NetworkingDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            GetLocalHostIpV4::class => autowire(LocalHostIpV4Getter::class),
        ];
    }
}
