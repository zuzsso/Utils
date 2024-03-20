<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryForbiddenException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
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
    public function keyArrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minCount,
        ?int $maxCount,
        bool $required = true
    ): self {
        if (($minCount === null) && ($maxCount === null)) {
            throw new IncorrectParametrizationException('No range given');
        }

        if (($minCount !== null) && ($maxCount !== null) && ($minCount >= $maxCount)) {
            throw new IncorrectParametrizationException(
                'Range not correctly defined. minCount should be < than max count, strictly'
            );
        }

        if ($minCount !== null && $minCount < 1) {
            // Because of the same reason we reject empty strings ('', '     '), we also reject empty arrays. They
            // should be replaced by NULLS in any case.
            //
            // Negative ranges are out of the question, but 0 ranges appear to be legit. However, allowing a min count
            // of 0 will result on an empty array, so the min count should be at least 1.
            //
            // So, if your array is between 0 and 3 elements, then you should pass a range of 1-3 to this function,
            // with the required flag set to true. And make sure you pass an array of at least one element, or null if
            // no elements
            throw new IncorrectParametrizationException("Zero or negative range is not allowed as min count.");
        }

        if (($maxCount !== null) && ($maxCount < 1)) {
            // Similar reasoning as before.
            throw new IncorrectParametrizationException("Values < 1 are not allowed as max count.");
        }

        if ($required === false) {
            try {
                $this->checkPropertyPresence->forbidden($key, $payload);
                return $this;
            } catch (EntryForbiddenException $e) {
            }
        }

        $this->requiredKey($key, $payload);

        $count = count($payload[$key]);

        if (($minCount !== null) && ($count < $minCount)) {
            throw ValueTooSmallException::constructForKeyArray($key, $minCount, $count);
        }

        if (($maxCount !== null) && ($count > $maxCount)) {
            throw ValueTooBigException::constructForKeyArrayLength($key, $maxCount, $count);
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
