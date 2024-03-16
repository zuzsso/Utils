<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ArrayExceedsMaximumnAllowedNumberOfElementsException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(int $expectedMaxCountIncluding, int $actualCount): self
    {
        return new self(
            "Maximum element count is %expectedMaxCountIncluding%, but the array has %actualCount%",
            [
                'expectedMaxCountIncluding' => $expectedMaxCountIncluding,
                'actualCount' => $actualCount
            ]
        );
    }

    public function errorCode(): string
    {
        return 'exceededMaxElementCount';
    }
}
