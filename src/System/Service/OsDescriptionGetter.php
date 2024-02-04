<?php

declare(strict_types=1);

namespace Utils\System\Service;

use Utils\System\UseCase\GetOSDescription;

class OsDescriptionGetter implements GetOSDescription
{
    /**
     * @inheritDoc
     */
    public function get(): string
    {
        return php_uname('m');
    }
}
