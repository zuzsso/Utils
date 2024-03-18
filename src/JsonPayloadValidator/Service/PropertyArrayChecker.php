<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use InvalidArgumentException;
use Utils\JsonPayloadValidator\Exception\ArrayDoesNotHaveMinimumElementCountException;
use Utils\JsonPayloadValidator\Exception\ArrayExceedsMaximumnAllowedNumberOfElementsException;
use Utils\JsonPayloadValidator\Exception\ArrayWithCustomIndexNumeration;
use Utils\JsonPayloadValidator\Exception\AssociatedValueToArrayKeyNotJsonObjectException;
use Utils\JsonPayloadValidator\Exception\NotNumericArrayIndexException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\UseCase\CheckPropertyArray;

class PropertyArrayChecker implements CheckPropertyArray
{
    /**
     * @inheritDoc
     */
    public function required(string $key, array $payload): self
    {
        if (!isset($payload[$key]) || !is_array($payload[$key])) {
            throw ValueNotAnArrayException::constructForStandardMessage($key);
        }

        return $this;
    }

    public function optional(string $key, array $payload): CheckPropertyArray
    {
        // TODO: Implement optional() method.
    }


    /**
     * @inheritDoc
     */
    public function arrayOfJsonObjects(array $arrayElements): self
    {
        $minKey = null;
        $maxKey = null;

        foreach ($arrayElements as $subkey => $value) {
            $castSubkey = (int)$subkey;

            if (((string)$castSubkey) !== ((string)$subkey)) {
                throw NotNumericArrayIndexException::constructForStandardMessage((string)$subkey);
            }

            if (($minKey === null) || ($subkey < $minKey)) {
                $minKey = $subkey;
            }

            if (($maxKey === null) || ($maxKey < $subkey)) {
                $maxKey = $subkey;
            }

            if (!is_array($value)) {
                throw AssociatedValueToArrayKeyNotJsonObjectException::constructForStandardMessage((string)$subkey);
            }
        }

        if (($minKey !== 0) || ($maxKey !== count($arrayElements) - 1)) {
            throw ArrayWithCustomIndexNumeration::constructForCustomNumeration();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function requiredArrayOfJsonObjects(string $key, array $payload): self
    {
        $this->required($key, $payload);

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
        $this->required($key, $payload);

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
}
