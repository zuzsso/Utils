<?php

declare(strict_types=1);

namespace Utils;

use Utils\Cryptography\CryptographyDependencyInjection;
use Utils\DateAndTime\DateAndTimeDependencyInjection;
use Utils\EmailAddress\EmailAddressDependencyInjection;
use Utils\Files\FilesDependencyInjection;
use Utils\Math\MathDependencyInjection;
use Utils\Networking\NetworkingDependencyInjection;
use Utils\System\SystemDependencyInjection;

class UtilsDependencyInjectionManifest extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return array_merge(
            CryptographyDependencyInjection::getDependencies(),
            DateAndTimeDependencyInjection::getDependencies(),
            EmailAddressDependencyInjection::getDependencies(),
            FilesDependencyInjection::getDependencies(),
            MathDependencyInjection::getDependencies(),
            NetworkingDependencyInjection::getDependencies(),
            SystemDependencyInjection::getDependencies()
        );
    }
}
