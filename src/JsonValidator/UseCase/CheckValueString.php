<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\InvalidDateValueException;
use Utils\JsonValidator\Exception\OptionalValueNotAStringException;
use Utils\JsonValidator\Exception\ValueStringEmptyException;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
interface CheckValueString
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws ValueStringEmptyException
     */
    public function required(?string $value): self;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @throws InvalidDateValueException
     * @throws OptionalValueNotAStringException
     * @throws ValueStringEmptyException
     */
    public function dateTimeFormat(?string $value, string $dateFormat, bool $required = true): self;
}
