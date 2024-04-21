<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryForbiddenException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\OptionalPropertyNotAnArrayException;
use Utils\JsonValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonValidator\Exception\ValueNotAnArrayException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\AbstractIntegerRange;
use Utils\JsonValidator\Types\Range\ArrayLengthRange;
use Utils\JsonValidator\UseCase\CheckKeyArray;
use Utils\JsonValidator\UseCase\CheckKeyPresence;
use Utils\JsonValidator\UseCase\CheckValueArray;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class KeyArrayChecker extends AbstractJsonChecker implements CheckKeyArray
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    private CheckKeyPresence $checkPropertyPresence;
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    private CheckValueArray $checkValueArray;

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function __construct(CheckKeyPresence $checkPropertyPresence, CheckValueArray $checkValueArray)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
        $this->checkValueArray = $checkValueArray;
    }

    /**
     * @inheritDoc
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function requiredKey(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $value = $payload[$key];

        if (!is_array($value)) {
            throw ValueNotAnArrayException::constructForStandardMessage($key);
        }

        $count = count($value);

        if ($count === 0) {
            throw RequiredArrayIsEmptyException::constructForStandardMessage();
        }

        $this->checkAllKeysAreNumericAndNoGaps($value);

        return $this;
    }

    /**
     * @inheritDoc
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function optionalKey(string $key, array $payload): CheckKeyArray
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
        }

        $value = $payload[$key];

        if (!is_array($value)) {
            throw OptionalPropertyNotAnArrayException::constructForKey($key);
        }


        if (count($value) === 0) {
            return $this;
        }

        try {
            $this->requiredKey($key, $payload);
        } catch (EntryEmptyException | EntryMissingException $e) {
            return $this;
        } catch (RequiredArrayIsEmptyException $e) {
            throw OptionalPropertyNotAnArrayException::constructForKey($key);
        }


        return $this;
    }

    /**
     * @inheritDoc
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function keyArrayOfJsonObjects(string $key, array $payload, bool $required = true): self
    {
        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }


        $this->requiredKey($key, $payload);

        $arrayElements = $payload[$key];

        $this->checkValueArray->arrayOfJsonObjects($arrayElements);

        return $this;
    }

    /**
     * @inheritDoc
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function keyArrayOfExactLength(string $key, array $payload, int $expectedLength, bool $required = true): self
    {
        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        $value = $payload[$key];

        try {
            $this->checkValueArray->arrayOfExactLength($value, $expectedLength);
        } catch (ValueArrayNotExactLengthException $e) {
            throw ValueArrayNotExactLengthException::constructForKeyArray($key, $expectedLength, count($value));
        }
        return $this;
    }

    /**
     * @inheritDoc
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function keyArrayOfLengthRange(
        string $key,
        array $payload,
        ArrayLengthRange $lengthRange,
        bool $required = true
    ): self {
        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        try {
            $this->checkValueArray->arrayOfLengthRange($payload[$key], $lengthRange);
        } catch (ValueTooBigException $e) {
            throw ValueTooBigException::constructForKeyArrayLength($key, $lengthRange->getMax(), count($payload[$key]));
        } catch (ValueTooSmallException $e) {
            throw ValueTooSmallException::constructForKeyArray($key, $lengthRange->getMin(), count($payload[$key]));
        }

        return $this;
    }
}
