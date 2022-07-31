<?php

declare(strict_types=1);


namespace Utils\EmailAddress\Service;

use Utils\EmailAddress\UseCase\ValidateEmailAddress;

class EmailAddressValidator implements ValidateEmailAddress {
    public function isValidEmailAddress(string $emailAddress): bool {
        return filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== false;
    }
}
