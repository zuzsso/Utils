<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Service;

use Utils\JsonValidator\Exception\ValueNotAnArrayException;

abstract class AbstractJsonChecker
{
    /**
     * @throws ValueNotAnArrayException
     */
    protected function checkAllKeysAreNumericAndNoGaps(array $array): void
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

    //    /**
    //     * @throws IncorrectParametrizationException
    //     */
    //    protected function checkRanges(?int $minLength, ?int $maxLength): void
    //    {
    //        if (($minLength === null) && ($maxLength === null)) {
    //            throw new IncorrectParametrizationException('No range given');
    //        }
    //
    //        if (($minLength !== null) && ($maxLength !== null) && ($minLength >= $maxLength)) {
    //            throw new IncorrectParametrizationException(
    //                'Range not correctly defined. minCount should be < than max count, strictly'
    //            );
    //        }
    //
    //        if ($minLength !== null && $minLength < 1) {
    //            throw new IncorrectParametrizationException("Zero or negative range is not allowed as min count.");
    //        }
    //
    //        if (($maxLength !== null) && ($maxLength < 1)) {
    //            // Similar reasoning as before.
    //            throw new IncorrectParametrizationException("Values < 1 are not allowed as max count.");
    //        }
    //    }
}
