<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator;

use Utils\AbstractDependencyInjection;
use Utils\JsonPayloadValidator\Service\KeyArrayChecker;
use Utils\JsonPayloadValidator\Service\KeyBooleanChecker;
use Utils\JsonPayloadValidator\Service\KeyEnumChecker;
use Utils\JsonPayloadValidator\Service\KeyFloatChecker;
use Utils\JsonPayloadValidator\Service\KeyIntegerChecker;
use Utils\JsonPayloadValidator\Service\KeyPresenceChecker;
use Utils\JsonPayloadValidator\Service\KeyStringChecker;
use Utils\JsonPayloadValidator\Service\ValueArrayChecker;
use Utils\JsonPayloadValidator\UseCase\CheckKeyArray;
use Utils\JsonPayloadValidator\UseCase\CheckKeyBoolean;
use Utils\JsonPayloadValidator\UseCase\CheckKeyEnum;
use Utils\JsonPayloadValidator\UseCase\CheckKeyFloat;
use Utils\JsonPayloadValidator\UseCase\CheckKeyInteger;
use Utils\JsonPayloadValidator\UseCase\CheckKeyPresence;
use Utils\JsonPayloadValidator\UseCase\CheckKeyString;

use Utils\JsonPayloadValidator\UseCase\CheckValueArray;

use function DI\autowire;

class JsonPayloadValidatorDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            CheckKeyArray::class => autowire(KeyArrayChecker::class),
            CheckKeyEnum::class => autowire(KeyEnumChecker::class),
            CheckKeyFloat::class => autowire(KeyFloatChecker::class),
            CheckKeyInteger::class => autowire(KeyIntegerChecker::class),
            CheckKeyPresence::class => autowire(KeyPresenceChecker::class),
            CheckKeyString::class => autowire(KeyStringChecker::class),
            CheckKeyBoolean::class => autowire(KeyBooleanChecker::class),
            CheckValueArray::class => autowire(ValueArrayChecker::class)
        ];
    }
}
