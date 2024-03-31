<?php

declare(strict_types=1);

namespace Utils\Tests\Database\Service;

use PHPUnit\Framework\TestCase;
use Utils\Database\Service\PdoParameterNamesChecker;

class PdoParameterNameCheckerTest extends TestCase
{
    private PdoParameterNamesChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new PdoParameterNamesChecker();
    }

    public function correctlyIdentifiesPdoParameterNamesDataProvider(): array
    {
        return [
            [":param", false],
            ["param1 param2", false],
            [" param1 ", false],

            ["param", true],
            ["param123", true],
            ["parAm123__", true]
        ];
    }

    /**
     * @dataProvider correctlyIdentifiesPdoParameterNamesDataProvider
     */
    public function testCorrectlyIdentifiesPdoParameterNames(string $pdoParameterName, bool $expected): void
    {
        $actual = $this->sut->checkStringRepresentsParameterName($pdoParameterName);

        self::assertEquals($expected, $actual);
    }
}
