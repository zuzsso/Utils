<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\InvalidBoolValueException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyBoolean;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;

class PropertyBooleanChecker implements CheckPropertyBoolean
{
    private CheckPropertyPresence $checkPropertyPresence;

    public function __construct(CheckPropertyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): CheckPropertyBoolean
    {
        $this->checkPropertyPresence->required($key, $payload);

        $originalValue = $payload[$key];

        if (!is_bool($originalValue)) {
            throw InvalidBoolValueException::constructForStandardMessage($key);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optional(string $key, array $payload): CheckPropertyBoolean
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
        }

        $this->required($key, $payload);

        return $this;
    }
}
