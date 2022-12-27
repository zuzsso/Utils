<?php

declare(strict_types=1);


namespace Utils\System\UseCase;

use Utils\System\Service\GetOSDescription;

class OsDescriptionGetter implements GetOSDescription {
    /**
     * @inheritDoc
     */
    public function get(): string {
        return php_uname('m');
    }
}
