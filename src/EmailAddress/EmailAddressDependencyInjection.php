<?php

declare(strict_types=1);

namespace Utils\EmailAddress;

use Utils\AbstractDependencyInjection;
use Utils\EmailAddress\Service\EmailAddressValidator;
use Utils\EmailAddress\UseCase\ValidateEmailAddress;
use function DI\autowire;

class EmailAddressDependencyInjection extends AbstractDependencyInjection {
    public static function getDependencies(): array {
        return [
            ValidateEmailAddress::class => autowire(EmailAddressValidator::class),
        ];
    }
}
