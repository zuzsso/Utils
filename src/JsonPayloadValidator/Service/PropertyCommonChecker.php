<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;


use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnEnumException;
use Utils\JsonPayloadValidator\Exception\ValueNotInListException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyCommon;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;

class PropertyCommonChecker implements CheckPropertyCommon
{
    private CheckPropertyPresence $checkPropertyPresence;

    public function __construct(CheckPropertyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function isEnum(string $key, array $payload, array $validValues): self
    {
        $this->checkPropertyPresence->required($key, $payload);
        $value = $payload[$key];

        if (!in_array($value, $validValues, true)) {
            throw ValueNotInListException::constructForList($key, $validValues, (string)$value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function optionalEnum(string $key, array $payload, array $validValues): self
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
            // The property exists, so make sure it is a proper enum
            try {
                $this->isEnum($key, $payload, $validValues);
                return $this;
            } catch (EntryEmptyException | EntryMissingException | ValueNotInListException $e) {
                throw OptionalPropertyNotAnEnumException::constructForList($key, $validValues, $payload[$key]);
            }
        }
    }
}
