<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\ValueNotInListException;
use Utils\JsonPayloadValidator\UseCase\CheckKeyCommon;
use Utils\JsonPayloadValidator\UseCase\CheckKeyPresence;

class KeyCommonChecker extends AbstractJsonChecker implements CheckKeyCommon
{
    private CheckKeyPresence $checkPropertyPresence;

    public function __construct(CheckKeyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function isEnum(string $key, array $payload, array $validValues, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                // The property does not exist in the payload, but is not required anyway, so return
                return $this;
            } catch (EntryForbiddenException $e) {
                // The property exists in the payload, so validate it
            }
        }

        $this->checkPropertyPresence->required($key, $payload);
        $value = $payload[$key];

        if (!in_array($value, $validValues, true)) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_THROW_ON_ERROR);
            }
            throw ValueNotInListException::constructForList($key, $validValues, (string)$value);
        }

        return $this;
    }
}
