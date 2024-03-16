<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class ArrayDoesNotHaveMinimumElementCountException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(int $expectedMinCountIncluding, int $actualCount): self
    {
        return new self(
            "Array should have at least '%expectedMinCountIncluding%' elements, but has '%actualCount%'",
            [
                'expectedMinCountIncluding' => $expectedMinCountIncluding,
                'actualCount' => $actualCount
            ]
        );
    }

    public function errorCode(): string
    {
        return 'requiredMinimumElementArrayCount';
    }
}
