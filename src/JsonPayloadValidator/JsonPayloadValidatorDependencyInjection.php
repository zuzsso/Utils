<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator;

use Utils\AbstractDependencyInjection;
use Utils\JsonPayloadValidator\Service\PropertyArrayChecker;
use Utils\JsonPayloadValidator\Service\PropertyBooleanChecker;
use Utils\JsonPayloadValidator\Service\PropertyCommonChecker;
use Utils\JsonPayloadValidator\Service\PropertyFloatChecker;
use Utils\JsonPayloadValidator\Service\PropertyIntegerChecker;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;
use Utils\JsonPayloadValidator\Service\PropertyStringChecker;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyArray;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyBoolean;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyCommon;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyFloat;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyInteger;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyString;

use function DI\autowire;

class JsonPayloadValidatorDependencyInjection extends AbstractDependencyInjection
{
    public static function getDependencies(): array
    {
        return [
            CheckPropertyArray::class => autowire(PropertyArrayChecker::class),
            CheckPropertyCommon::class => autowire(PropertyCommonChecker::class),
            CheckPropertyFloat::class => autowire(PropertyFloatChecker::class),
            CheckPropertyInteger::class => autowire(PropertyIntegerChecker::class),
            CheckPropertyPresence::class => autowire(PropertyPresenceChecker::class),
            CheckPropertyString::class => autowire(PropertyStringChecker::class),
            CheckPropertyBoolean::class => autowire(PropertyBooleanChecker::class)
        ];
    }
}
