<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class AssociatedValueToArrayKeyNotJsonObjectException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $subKey): self
    {
        return new self(
            "Item index '%subKey%' is not a JSON object",
            [
                'subKey' => $subKey
            ]
        );
    }

    public function errorCode(): string
    {
        return 'valueNotAJsonObject';
    }
}
