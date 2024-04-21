<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

/**
 * @deprecated
 * Migrated to zuzsso/json-validator
 */
class IntegerComponentsDontRepresentDate extends AbstractMalformedRequestBody
{
    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public static function constructForStandardMessage(int $year, int $month, int $day): self
    {
        return new self(
            "Cannot construct a date with year '$year', month '$month' and day '$day'"
        );
    }

    /**
     * @deprecated
     * Migrated to zuzsso/json-validator
     */
    public function getErrorCode(): string
    {
        return 'integerComponentsNotADate';
    }
}
