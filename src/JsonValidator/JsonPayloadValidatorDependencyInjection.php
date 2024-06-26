<?php

declare(strict_types=1);

namespace Utils\JsonValidator;

use Utils\AbstractDependencyInjection;
use Utils\JsonValidator\Service\KeyArrayChecker;
use Utils\JsonValidator\Service\KeyBooleanChecker;
use Utils\JsonValidator\Service\KeyEnumChecker;
use Utils\JsonValidator\Service\KeyFloatChecker;
use Utils\JsonValidator\Service\KeyIntegerChecker;
use Utils\JsonValidator\Service\KeyJsonObjectChecker;
use Utils\JsonValidator\Service\KeyPresenceChecker;
use Utils\JsonValidator\Service\KeyStringChecker;
use Utils\JsonValidator\Service\ValueArrayChecker;
use Utils\JsonValidator\Service\ValueIntegerChecker;
use Utils\JsonValidator\Service\ValueStringChecker;
use Utils\JsonValidator\UseCase\CheckKeyArray;
use Utils\JsonValidator\UseCase\CheckKeyBoolean;
use Utils\JsonValidator\UseCase\CheckKeyEnum;
use Utils\JsonValidator\UseCase\CheckKeyFloat;
use Utils\JsonValidator\UseCase\CheckKeyInteger;
use Utils\JsonValidator\UseCase\CheckKeyJsonObject;
use Utils\JsonValidator\UseCase\CheckKeyPresence;
use Utils\JsonValidator\UseCase\CheckKeyString;
use Utils\JsonValidator\UseCase\CheckValueArray;

use Utils\JsonValidator\UseCase\CheckValueInteger;
use Utils\JsonValidator\UseCase\CheckValueString;

use function DI\autowire;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class JsonPayloadValidatorDependencyInjection extends AbstractDependencyInjection
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function getDependencies(): array
    {
        return [
            CheckKeyJsonObject::class => autowire(KeyJsonObjectChecker::class),
            CheckKeyArray::class => autowire(KeyArrayChecker::class),
            CheckKeyEnum::class => autowire(KeyEnumChecker::class),
            CheckKeyFloat::class => autowire(KeyFloatChecker::class),
            CheckKeyInteger::class => autowire(KeyIntegerChecker::class),
            CheckKeyPresence::class => autowire(KeyPresenceChecker::class),
            CheckKeyString::class => autowire(KeyStringChecker::class),
            CheckKeyBoolean::class => autowire(KeyBooleanChecker::class),
            CheckValueString::class => autowire(ValueStringChecker::class),
            CheckValueInteger::class => autowire(ValueIntegerChecker::class),
            CheckValueArray::class => autowire(ValueArrayChecker::class)
        ];
    }
}
