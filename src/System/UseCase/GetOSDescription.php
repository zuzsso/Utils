<?php

declare(strict_types=1);

namespace Utils\System\UseCase;

interface GetOSDescription
{
    /**
     * @return string
     */
    public function get(): string;
}
