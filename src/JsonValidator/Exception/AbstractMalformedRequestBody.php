<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

use Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
abstract class AbstractMalformedRequestBody extends Exception
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    abstract public function getErrorCode(): string;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    final public function serialize(): array
    {
        return [
            'code' => $this->getErrorCode(),
            'message' => $this->getMessage()
        ];
    }
}
