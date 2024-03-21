<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Service\ValueArrayChecker;

class ValueArrayCheckerTest extends TestCase
{
    private ValueArrayChecker $sut;

    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new ValueArrayChecker();
    }
}
