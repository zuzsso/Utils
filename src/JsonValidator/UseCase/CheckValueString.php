<?php

declare(strict_types=1);

namespace Utils\JsonValidator\UseCase;

use Utils\JsonValidator\Exception\ValueStringEmptyException;

interface CheckValueString
{
    /**
     * @throws ValueStringEmptyException
     */
    public function required(?string $value): self;
}
