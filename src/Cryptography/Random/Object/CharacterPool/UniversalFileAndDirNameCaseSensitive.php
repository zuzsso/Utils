<?php

declare(strict_types=1);


namespace Utils\Cryptography\Random\Object\CharacterPool;

class UniversalFileAndDirNameCaseSensitive extends AlphanumericCaseSensitive {
    public function __construct() {
        parent::__construct();
        $this->addCharacterToPool('{');
        $this->addCharacterToPool('}');
        $this->addCharacterToPool('!');
        $this->addCharacterToPool('$');
        $this->addCharacterToPool('%');
        $this->addCharacterToPool('=');
        $this->addCharacterToPool('@');
        $this->addCharacterToPool('_');
    }
}
