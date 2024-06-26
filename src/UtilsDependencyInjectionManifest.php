<?php

declare(strict_types=1);

namespace Utils;

use Utils\Cryptography\CryptographyDependencyInjection;
use Utils\Database\DatabaseDependencyInjection;
use Utils\DateAndTime\DateAndTimeDependencyInjection;
use Utils\EmailAddress\EmailAddressDependencyInjection;
use Utils\Files\FilesDependencyInjection;
use Utils\JsonValidator\JsonPayloadValidatorDependencyInjection;
use Utils\Math\MathDependencyInjection;
use Utils\Networking\NetworkingDependencyInjection;
use Utils\System\SystemDependencyInjection;

/**
 * @deprecated
 * Utils repo is being broken down into smaller chunks
 */
class UtilsDependencyInjectionManifest extends AbstractDependencyInjection
{
    /**
     * @deprecated
     * Utils repo is being broken down into smaller chunks
     */
    public static function getDependencies(): array
    {
        return array_merge(
            CryptographyDependencyInjection::getDependencies(),
            DateAndTimeDependencyInjection::getDependencies(),
            EmailAddressDependencyInjection::getDependencies(),
            FilesDependencyInjection::getDependencies(),
            MathDependencyInjection::getDependencies(),
            NetworkingDependencyInjection::getDependencies(),
            SystemDependencyInjection::getDependencies(),
            JsonPayloadValidatorDependencyInjection::getDependencies(),
            DatabaseDependencyInjection::getDependencies()
        );
    }
}
