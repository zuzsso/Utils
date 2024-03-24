<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

use Exception;

abstract class AbstractMalformedRequestBody extends Exception
{
    final public function serialize(): array
    {
        return [
            'code' => $this->getCode(),
            'message' => $this->getMessage()
        ];
    }
}
