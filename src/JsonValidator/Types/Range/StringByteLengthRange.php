<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Types\Range;

use Utils\JsonValidator\Exception\IncorrectParametrizationException;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class StringByteLengthRange extends AbstractIntegerRange
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function __construct(?int $min, ?int $max)
    {
        if ($min !== null && $min < 1) {
            throw new IncorrectParametrizationException(
                "Zero or negative range is not allowed as min value. Given: $min."
            );
        }

        if (($max !== null) && ($max < 1)) {

            throw new IncorrectParametrizationException("Values < 1 are not allowed as max count. Given: $max");
        }

        parent::__construct($min, $max);
    }
}
