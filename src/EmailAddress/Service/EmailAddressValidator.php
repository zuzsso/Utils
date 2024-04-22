<?php

declare(strict_types=1);

namespace Utils\EmailAddress\Service;

use Utils\EmailAddress\UseCase\ValidateEmailAddress;

/**
 * @deprecated
 * migrated to zuzsso/json-validator
 */
class EmailAddressValidator implements ValidateEmailAddress
{
    /**
     * @deprecated
     * migrated to zuzsso/json-validator
     */
    public static function isValidEmailAddressStatic(string $emailAddress): bool
    {
        return filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * @deprecated
     * migrated to zuzsso/json-validator
     */
    public function isValidEmailAddress(string $emailAddress): bool
    {
        return self::isValidEmailAddressStatic($emailAddress);
    }
}
