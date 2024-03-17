<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class InvalidDateValueException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $key, string $format, string $value): self
    {
        return new self("Entry '$key' does not hold a valid '$format' date: '$value'");
    }

    public function errorCode(): string
    {
        return 'invalidDateFormat';
    }
}
