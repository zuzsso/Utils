<?php

declare(strict_types=1);

namespace Utils\Files\UseCase;

interface CheckDirectoryIsReadable {
    public function check(string $dir): bool;
}
