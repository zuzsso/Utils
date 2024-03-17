<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\Exception;

class StringIsNotAnUrlException extends AbstractMalformedRequestBody
{
    public static function constructForStandardMessage(string $url): self
    {
        return new self("The string '$url' doesn't resemble an actual URL");
    }

    public function errorCode(): string
    {
        return 'requiredUrlFormat';
    }
}
