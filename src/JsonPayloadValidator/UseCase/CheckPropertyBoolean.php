<?php

declare(strict_types=1);

namespace Utils\JsonPayloadValidator\UseCase;

interface CheckPropertyBoolean
{
    public function required(string $key, array $payload): self;

    public function optional(string $key, array $payload): self;
}
