<?php

declare(strict_types=1);


namespace Utils\EmailAddress\UseCase;

interface ValidateEmailAddress {
    public function isValidEmailAddress(string $emailAddress): bool;
}
