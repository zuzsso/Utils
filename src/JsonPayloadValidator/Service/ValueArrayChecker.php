<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Service;

use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\UseCase\CheckValueArray;

class ValueArrayChecker extends AbstractJsonChecker implements CheckValueArray
{
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
    public function keyArrayOfLengthRange(
        array $payload,
        ?int $minLength,
        ?int $maxLength
    ): CheckValueArray {
        $this->checkRanges($minLength, $maxLength);

        $count = count($payload);

        if (($minLength !== null) && ($count < $minLength)) {
            throw ValueTooSmallException::constructForValueArray($minLength, $count);
        }

        if (($maxLength !== null) && ($count > $maxLength)) {
            throw ValueTooBigException::constructForValueArrayLength($maxLength, $count);
        }

        return $this;
    }
}
