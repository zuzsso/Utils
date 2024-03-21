<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;

interface CheckValueArray
{
    /**
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     */
    public function arrayOfJsonObjects(array $arrayElements, bool $required = true): self;
}
