<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\UseCase\CheckPropertyBoolean;

class PropertyBooleanChecker implements CheckPropertyBoolean
{
    public function required(string $key, array $payload): CheckPropertyBoolean
    {
        // TODO: Implement required() method.
    }

    public function optional(string $key, array $payload): CheckPropertyBoolean
    {
        // TODO: Implement optional() method.
    }
}
