<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\IncorrectParametrizationException;
use Utils\JsonValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonValidator\Exception\ValueArrayNotExactLengthException;
use Utils\JsonValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonValidator\Exception\ValueTooBigException;
use Utils\JsonValidator\Exception\ValueTooSmallException;
use Utils\JsonValidator\Types\Range\ArrayLengthRange;
use Utils\JsonValidator\UseCase\CheckValueArray;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class ValueArrayChecker extends AbstractJsonChecker implements CheckValueArray
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
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
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function arrayOfLengthRange(
        array $payload,
        ArrayLengthRange $lengthRange
    ): CheckValueArray {

        $count = count($payload);

        $this->checkAllKeysAreNumericAndNoGaps($payload);

        $minLength = $lengthRange->getMin();
        $maxLength = $lengthRange->getMax();

        if (($minLength !== null) && ($count < $minLength)) {
            throw ValueTooSmallException::constructForValueArray($minLength, $count);
        }

        if (($maxLength !== null) && ($count > $maxLength)) {
            throw ValueTooBigException::constructForValueArrayLength($maxLength, $count);
        }

        return $this;
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     * @inheritDoc
     */
    public function arrayOfExactLength(array $payload, int $expectedLength): CheckValueArray
    {
        if ($expectedLength <= 0) {
            throw new IncorrectParametrizationException('Min required length is 1');
        }

        $this->checkAllKeysAreNumericAndNoGaps($payload);

        $count = count($payload);

        if ($count !== $expectedLength) {
            throw ValueArrayNotExactLengthException::constructForValueArray($expectedLength, $count);
        }

        return $this;
    }
}
