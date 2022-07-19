<?php

namespace Utils\Files\UseCase;

interface CheckDirectoryIsWriteable {
    public function check(string $dir): bool;
}
