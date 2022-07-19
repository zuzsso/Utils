<?php

declare(strict_types=1);


namespace Utils\Files\Service;

class DirectoryIsWriteableChecker {
    public function check(string $dir): bool {
        $fileName = uniqid('', true);

        $path = $dir . '/' . $fileName;

        set_error_handler(static function () {/* Ignore warnings if the directory is not writeable */});

        $success = file_put_contents($path, 'random text');

        restore_error_handler();

        if ($success !== false) {
            unlink($path);
        }

        return $success !== false;
    }
}
