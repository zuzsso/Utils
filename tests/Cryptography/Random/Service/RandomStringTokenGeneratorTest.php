<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Random\Service;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Utils\Cryptography\Random\Object\CharacterPool\HexadecimalLowerCaseCharacterPool;
use Utils\Cryptography\Random\Service\RandomStringTokenGenerator;
use Utils\Tests\Cryptography\Random\Mocks\GenericCharacterPoolMock;

class RandomStringTokenGeneratorTest extends TestCase {
    private RandomStringTokenGenerator $sut;

    public function setUp(): void {
        parent::setUp();
        $this->sut = new RandomStringTokenGenerator();
    }

    /**
     * @throws Exception
     */
    public function testGeneratesHexStringsOfGivenLength(): void {
        for ($i = 1; $i < 100; $i++) {
            $actual = $this->sut->generateRandomStringOfLengthInChars(new HexadecimalLowerCaseCharacterPool(), $i);
            self::assertEquals($i, strlen($actual));
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHexGeneratorOnlyUsesHexChars(): void {
        for ($i = 0; $i < 100; $i++) {
            $actual = $this->sut->generateRandomStringOfLengthInChars(new HexadecimalLowerCaseCharacterPool(), 100);
            self::assertTrue($this->assertStringContainsOnlyHexChars($actual));
        }
    }

    public function throwsExceptionIfTryingToGenerateHexRandomTokenWithWrongParametersDataProvider(): array {
        return [
            [0],
            [-1],
            [-2]
        ];
    }

    /**
     * @param int $requiredLength
     * @return void
     * @throws Exception
     * @dataProvider throwsExceptionIfTryingToGenerateHexRandomTokenWithWrongParametersDataProvider
     */
    public function testThrowsExceptionIfTryingToGenerateHexRandomTokenWithWrongParameters(
        int $requiredLength
    ): void {
        $this->expectException(InvalidArgumentException::class);

        $this->sut->generateRandomStringOfLengthInChars(new HexadecimalLowerCaseCharacterPool(), $requiredLength);
    }

    private function assertStringContainsOnlyHexChars(string $string): bool {
        $valid = "0123456789abcdef";

        $aux = strtolower($string);

        $length = strlen($aux);

        for ($i = 0; $i < $length; $i++) {
            $currentChar = $aux[$i];
            if (strpos($valid, $currentChar) === false) {
                return false;
            }
        }
        return true;
    }


    /**
     * @throws Exception
     */
    public function testThrowsExceptionIfEmptyCharacterPool(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Character pool not big enough");
        $cp = new GenericCharacterPoolMock('');
        $this->sut->generateRandomStringOfLengthInChars($cp, 3);
    }

    /**
     * @throws Exception
     */
    public function testThrowsExceptionIfRequiredLengthTooSmall(): void {
        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage(
            "The current implementation only generates random strings of length [1, " .
            PHP_INT_MAX .
            "], but requested 0"
        );

        $cp = new GenericCharacterPoolMock('abc');
        $this->sut->generateRandomStringOfLengthInChars($cp, 0);
    }

    /**
     * @throws Exception
     */
    public function testGeneratesStringOfRequiredLength(): void {
        $cp = new GenericCharacterPoolMock('ab');
        $str = $this->sut->generateRandomStringOfLengthInChars($cp, 25);

        self::assertEquals(25, strlen($str));
    }

    /**
     * @throws Exception
     */
    public function testUsesAlCharactersInThePool(): void {
        $cp = new GenericCharacterPoolMock('abcd');
        $str = $this->sut->generateRandomStringOfLengthInChars($cp, 10000);

        self::assertEquals(10000, strlen($str));

        self::assertGreaterThanOrEqual(0, strpos($str, 'a'));
        self::assertGreaterThanOrEqual(0, strpos($str, 'b'));
        self::assertGreaterThanOrEqual(0, strpos($str, 'c'));
        self::assertGreaterThanOrEqual(0, strpos($str, 'd'));

        // Sanity test
        self::assertFalse(strpos($str, 'Z'));
    }

}
