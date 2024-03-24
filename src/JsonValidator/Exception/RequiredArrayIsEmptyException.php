<?php

declare(strict_types=1);

namespace Utils\JsonValidator\Exception;

class RequiredArrayIsEmptyException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(): self
    {
        return new self("The array is required not to be empty");
    }
}