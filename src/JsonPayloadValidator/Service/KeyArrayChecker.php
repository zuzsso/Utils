<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\UseCase\CheckKeyArray;
use Utils\JsonPayloadValidator\UseCase\CheckKeyPresence;

class KeyArrayChecker implements CheckKeyArray
{
    private CheckKeyPresence $checkPropertyPresence;

    public function __construct(CheckKeyPresence $checkPropertyPresence)
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

        $count = count($value);

        if ($count === 0) {
            throw RequiredArrayIsEmptyException::constructForStandardMessage();
        }

        $this->checkAllKeysAreNumericAndNoGaps($value);

        return $this;
    }

    /**
     * @throws OptionalPropertyNotAnArrayException
     * @throws ValueNotAnArrayException
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

        $this->arrayOfJsonObjects($arrayElements);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keyArrayOfLength(string $key, array $payload, int $length, bool $required = true): self
    {
        if ($length <= 0) {
            throw new IncorrectParametrizationException('Min required length is 1');
        }

        if (!$required) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        $value = $payload[$key];

        $count = count($value);

        if ($count !== $length) {
            throw ValueArrayNotExactLengthException::constructForKeyArray($key, $length, $count);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function keyArrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minLength,
        ?int $maxLength,
        bool $required = true
    ): self {
        $this->checkRanges($minLength, $maxLength);

        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        $count = count($payload[$key]);

        if (($minLength !== null) && ($count < $minLength)) {
            throw ValueTooSmallException::constructForKeyArray($key, $minLength, $count);
        }

        if (($maxLength !== null) && ($count > $maxLength)) {
            throw ValueTooBigException::constructForKeyArrayLength($key, $maxLength, $count);
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

    /**
     * @throws IncorrectParametrizationException
     */
    private function checkRanges(?int $minLength, ?int $maxLength): void
    {
        if (($minLength === null) && ($maxLength === null)) {
            throw new IncorrectParametrizationException('No range given');
        }

        if (($minLength !== null) && ($maxLength !== null) && ($minLength >= $maxLength)) {
            throw new IncorrectParametrizationException(
                'Range not correctly defined. minCount should be < than max count, strictly'
            );
        }

        if ($minLength !== null && $minLength < 1) {
            throw new IncorrectParametrizationException("Zero or negative range is not allowed as min count.");
        }

        if (($maxLength !== null) && ($maxLength < 1)) {
            // Similar reasoning as before.
            throw new IncorrectParametrizationException("Values < 1 are not allowed as max count.");
        }
    }
}
