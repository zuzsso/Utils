<?php

declare(strict_types=1);

namespace Utils\Cryptography\Random\Type\CharacterPool;

/**
 * @deprecated
 * Migrated to zuzsso/cryptography
 */
class MfaRecoveryCodeCharacterPool extends AbstractCharacterPool
{
    /**
     * @deprecated
     * Migrated to zuzsso/cryptography
     * @noinspection DuplicatedCode
     */
    public function __construct()
    {
        $this->addCharacterToPool("2");
        $this->addCharacterToPool("3");
        $this->addCharacterToPool("4");
        $this->addCharacterToPool("5");
        $this->addCharacterToPool("6");
        $this->addCharacterToPool("7");
        $this->addCharacterToPool("8");
        $this->addCharacterToPool("9");
        $this->addCharacterToPool("B");
        $this->addCharacterToPool("C");
        $this->addCharacterToPool("D");
        $this->addCharacterToPool("F");
        $this->addCharacterToPool("G");
        $this->addCharacterToPool("H");
        $this->addCharacterToPool("J");
        $this->addCharacterToPool("K");
        $this->addCharacterToPool("L");
        $this->addCharacterToPool("M");
        $this->addCharacterToPool("N");
        $this->addCharacterToPool("P");
        $this->addCharacterToPool("Q");
        $this->addCharacterToPool("R");
        $this->addCharacterToPool("S");
        $this->addCharacterToPool("T");
        $this->addCharacterToPool("V");
        $this->addCharacterToPool("W");
        $this->addCharacterToPool("X");
        $this->addCharacterToPool("Y");
        $this->addCharacterToPool("Z");
    }
}
