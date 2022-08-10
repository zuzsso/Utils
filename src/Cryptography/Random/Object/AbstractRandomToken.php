<?php

declare(strict_types=1);


namespace Utils\Cryptography\Random\Object;

abstract class AbstractRandomToken {
    protected string $token;

    public function __construct(string $token) {
        $this->token = $token;
    }

    public function getStringToken(): string {
        return $this->token;
    }
}
