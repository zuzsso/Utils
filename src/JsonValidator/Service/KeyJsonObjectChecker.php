<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\InvalidJsonObjectValueException;
use Utils\JsonValidator\UseCase\CheckKeyJsonObject;
use Utils\JsonValidator\UseCase\CheckKeyPresence;

class KeyJsonObjectChecker implements CheckKeyJsonObject
{
    private CheckKeyPresence $checkKeyPresence;

    public function __construct(CheckKeyPresence $checkKeyPresence)
    {
        $this->checkKeyPresence = $checkKeyPresence;
    }

    /**
     * @throws InvalidJsonObjectValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function required(string $key, array $payload): CheckKeyJsonObject
    {
        $this->checkKeyPresence->required($key, $payload);

        $payloadValue = $payload[$key];

        if (!is_array($payloadValue)) {
            throw InvalidJsonObjectValueException::constructForRequiredKey($key);
        }

        foreach ($payloadValue as $subKey => $value) {
            if (!is_string($subKey)) {
                throw InvalidJsonObjectValueException::constructForRequiredKey($key);
            }
        }

        return $this;
    }

    /**
     * @throws InvalidJsonObjectValueException
     */
    public function optional(string $key, array $payload): CheckKeyJsonObject
    {
        try {
            $this->checkKeyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
        }

        try {
            $this->required($key, $payload);
            return $this;
        } catch (EntryEmptyException | EntryMissingException | InvalidJsonObjectValueException $e) {
            throw InvalidJsonObjectValueException::constructForOptionalValue($key);
        }
    }
}
