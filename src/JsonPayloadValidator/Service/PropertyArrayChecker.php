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
    public function requiredArray(string $key, array $payload): self
    {
        if (!isset($payload[$key]) || !is_array($payload[$key])) {
            throw ValueNotAnArrayException::constructForStandardMessage($key);
        }

        return $this;
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
        $this->requiredArray($key, $payload);

        $arrayElements = $payload[$key];

        $this->arrayOfJsonObjects($arrayElements);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function requiredArrayOfLength(
        string $key,
        array $payload,
        ?int $minCountIncluding,
        ?int $maxCountIncluding
    ): self {
        $this->requiredArray($key, $payload);

        $count = count($payload[$key]);

        if ($minCountIncluding !== null) {
            if ($minCountIncluding < 0) {
                // Not translatable, you are invoking this function with incorrect parameters
                throw new InvalidArgumentException("minCountIncluding cannot be negative: $minCountIncluding");
            }

            if ($count < $minCountIncluding) {
                throw ArrayDoesNotHaveMinimumElementCountException::constructForStandardMessage(
                    $minCountIncluding,
                    $count
                );
            }
        }

        if ($maxCountIncluding !== null) {
            if (($minCountIncluding !== null) && ($maxCountIncluding < $minCountIncluding)) {
                // Not translatable, you are invoking this function with incorrect parameters
                throw new InvalidArgumentException(
                    "Both minCountIncluding and maxCountIncluded provided, but $maxCountIncluding < $minCountIncluding"
                );
            }

            if ($count > $maxCountIncluding) {
                throw ArrayExceedsMaximumnAllowedNumberOfElementsException::constructForStandardMessage(
                    $maxCountIncluding,
                    $count
                );
            }
        }

        return $this;
    }
}
