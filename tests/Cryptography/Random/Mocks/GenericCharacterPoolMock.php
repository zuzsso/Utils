<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Random\Mocks;

use Utils\Cryptography\Random\Type\CharacterPool\AbstractCharacterPool;

class GenericCharacterPoolMock extends AbstractCharacterPool
{
    public function __construct(string $chars)
    {
        $stringLength = strlen($chars);

        for ($i = 0; $i < $stringLength; $i++) {
            $this->addCharacterToPool($chars[$i]);
        }
    }
}
