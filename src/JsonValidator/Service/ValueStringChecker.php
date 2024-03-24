<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\ValueStringEmptyException;
use Utils\JsonValidator\UseCase\CheckValueString;

class ValueStringChecker implements CheckValueString
{
    /**
     * @inheritDoc
     */
    public function required(?string $value): CheckValueString
    {
        $sanitized = trim($value . '');

        if ($sanitized === '') {
            throw ValueStringEmptyException::constructForStandardMessage();
        }

        return $this;
    }
}
