<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class NotNumericArrayIndexException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $index): self
    {
        return new self(
            "Payload has array with not numeric indexes: '%index%'",
            [
                'index' => $index
            ]
        );
    }

    public function errorCode(): string
    {
        return 'arrayHasNotNumericIndexes';
    }
}
