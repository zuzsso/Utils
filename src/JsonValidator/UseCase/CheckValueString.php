<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\InvalidDateValueException;
use Utils\JsonValidator\Exception\OptionalValueNotAStringException;
use Utils\JsonValidator\Exception\ValueStringEmptyException;

interface CheckValueString
{
    /**
     * @throws ValueStringEmptyException
     */
    public function required(?string $value): self;

    /**
     * @throws InvalidDateValueException
     * @throws OptionalValueNotAStringException
     * @throws ValueStringEmptyException
     */
    public function dateTimeFormat(?string $value, string $dateFormat, bool $required = true): self;
}
