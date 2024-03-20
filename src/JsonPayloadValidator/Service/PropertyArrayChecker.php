<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use InvalidArgumentException;
use Utils\JsonPayloadValidator\Exception\ArrayDoesNotHaveMinimumElementCountException;
use Utils\JsonPayloadValidator\Exception\ArrayExceedsMaximumnAllowedNumberOfElementsException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyArray;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyPresence;

class PropertyArrayChecker implements CheckPropertyArray
{
    private CheckPropertyPresence $checkPropertyPresence;

    public function __construct(CheckPropertyPresence $checkPropertyPresence)
    {
        $this->checkPropertyPresence = $checkPropertyPresence;
    }

    /**
     * @inheritDoc
     */
    public function requiredKey(string $key, array $payload): self
    {
        $this->checkPropertyPresence->required($key, $payload);

        $value = $payload[$key];

        if (!is_array($value)) {
            throw ValueNotAnArrayException::constructForStandardMessage($key);
        }

        $this->checkAllKeysAreNumericAndNoGaps($value);

        return $this;
    }

    /**
     * @throws ValueNotAnArrayException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function optionalKey(string $key, array $payload): CheckPropertyArray
    {
        try {
            $this->checkPropertyPresence->forbidden($key, $payload);
            return $this;
        } catch (EntryForbiddenException $e) {
        }

        $value = $payload[$key];

        if (is_array($value) && count($value) === 0) {
            return $this;
        }

        $this->requiredKey($key, $payload);


        return $this;
    }

    /**
     * @inheritDoc
     */
    public function arrayOfJsonObjects(array $arrayElements, bool $required = true): self
    {
        $count = count($arrayElements);

        if (($count === 0)) {
            if ($required === false) {
                return $this;
            }

            throw RequiredArrayIsEmptyException::constructForStandardMessage();
        }

        $this->checkAllKeysAreNumericAndNoGaps($arrayElements);

        foreach ($arrayElements as $i => $r) {
            if (!is_array($r)) {
                throw ValueNotAJsonObjectException::constructForStandardMessage((string)$i);
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keyOfJsonObjects(string $key, array $payload, bool $required = true): self
    {
        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }



        $this->requiredKey($key, $payload);

        $value = $payload[$key];



        $arrayElements = $payload[$key];

        $this->arrayOfJsonObjects($arrayElements);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function arrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minCount,
        ?int $maxCount,
        bool $required = true
    ): self {
        $this->requiredKey($key, $payload);

        $count = count($payload[$key]);

        if ($minCount !== null) {
            if ($minCount < 0) {
                // Not translatable, you are invoking this function with incorrect parameters
                throw new InvalidArgumentException("minCountIncluding cannot be negative: $minCount");
            }

            if ($count < $minCount) {
                throw ArrayDoesNotHaveMinimumElementCountException::constructForStandardMessage(
                    $minCount,
                    $count
                );
            }
        }

        if ($maxCount !== null) {
            if (($minCount !== null) && ($maxCount < $minCount)) {
                // Not translatable, you are invoking this function with incorrect parameters
                throw new InvalidArgumentException(
                    "Both minCountIncluding and maxCountIncluded provided, but $maxCount < $minCount"
                );
            }

            if ($count > $maxCount) {
                throw ArrayExceedsMaximumnAllowedNumberOfElementsException::constructForStandardMessage(
                    $maxCount,
                    $count
                );
            }
        }

        return $this;
    }

    /**
     * @throws ValueNotAnArrayException
     */
    private function checkAllKeysAreNumericAndNoGaps(array $array): void
    {
        $count = count($array);

        if ($count === 0) {
            return;
        }

        $keys = array_keys($array);

        $min = null;
        $max = null;

        foreach ($keys as $k) {
            if (!is_int($k)) {
                throw ValueNotAnArrayException::associativeArraysNotSupported();
            }

            if ($min === null) {
                $min = $k;
            } elseif ($k < $min) {
                $min = $k;
            }

            if ($max === null) {
                $max = $k;
            } elseif ($k > $max) {
                $max = $k;
            }
        }

        if ($min !== 0) {
            throw ValueNotAnArrayException::firstArrayKeyNotZero();
        }

        $expectedMaxKey = $count - 1;

        if ($max !== $expectedMaxKey) {
            throw ValueNotAnArrayException::expectedLastKeyToBe($expectedMaxKey, $max);
        }
    }
}
