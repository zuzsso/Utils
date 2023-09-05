<?php

declare(strict_types=1);

namespace Utils\Cryptography;

use Utils\AbstractDependencyInjection;
use Utils\Cryptography\Hash\Service\HashService;
use Utils\Cryptography\Hash\UseCase\GenerateStringHash;
use Utils\Cryptography\Hash\UseCase\PasswordHash;
use Utils\Cryptography\Hash\UseCase\PasswordVerify;
use function DI\autowire;

class CryptographyDependencyInjection extends AbstractDependencyInjection {
    public static function getDependencies(): array {
        return [
            GenerateStringHash::class => autowire(HashService::class),
            PasswordHash::class => autowire(HashService::class),
            PasswordVerify::class => autowire(HashService::class)
        ];
    }
}
