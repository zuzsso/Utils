<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Type\CharacterPool;

/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
class HexadecimalUpperCaseCharacterPool extends AbstractCharacterPool
{
    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     * @noinspection DuplicatedCode
     */
    public function __construct()
    {
        $this->addCharacterToPool("0");
        $this->addCharacterToPool("1");
        $this->addCharacterToPool("2");
        $this->addCharacterToPool("3");
        $this->addCharacterToPool("4");
        $this->addCharacterToPool("5");
        $this->addCharacterToPool("6");
        $this->addCharacterToPool("7");
        $this->addCharacterToPool("8");
        $this->addCharacterToPool("9");
        $this->addCharacterToPool("A");
        $this->addCharacterToPool("B");
        $this->addCharacterToPool("C");
        $this->addCharacterToPool("D");
        $this->addCharacterToPool("E");
        $this->addCharacterToPool("F");
    }
}
