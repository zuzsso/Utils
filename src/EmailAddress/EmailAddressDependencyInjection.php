<?php

declare(strict_types=1);

namespace Utils\EmailAddress;

use Utils\AbstractDependencyInjection;
use Utils\EmailAddress\Service\EmailAddressValidator;
use Utils\EmailAddress\UseCase\ValidateEmailAddress;

use function DI\autowire;

/**
 * @deprecated
 * migrated to zuzsso/json-validator
 */
class EmailAddressDependencyInjection extends AbstractDependencyInjection
{
    /**
     * @deprecated
     * migrated to zuzsso/json-validator
     */
    public static function getDependencies(): array
    {
        return [
            ValidateEmailAddress::class => autowire(EmailAddressValidator::class),
        ];
    }
}
