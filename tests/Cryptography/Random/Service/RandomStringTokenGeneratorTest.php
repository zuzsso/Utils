<?php

declare(strict_types=1);

namespace Utils\Tests\Cryptography\Random\Service;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Utils\Cryptography\Random\Service\RandomStringTokenGenerator;

class RandomStringTokenGeneratorTest extends TestCase {
    private RandomStringTokenGenerator $sut;

    public function setUp(): void {
        parent::setUp();
        $this->sut = new RandomStringTokenGenerator();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGeneratesHexStringsOfGivenLength(): void {
        for ($i = 1; $i < 100; $i++) {
            $actual = $this->sut->hexTokenOfLengthRaw($i);
            self::assertEquals($i, strlen($actual));
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testHexGeneratorOnlyUsesHexChars(): void {
        for ($i = 0; $i < 100; $i++) {
            $actual = $this->sut->hexTokenOfLengthRaw(100);
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

        $this->sut->hexTokenOfLengthRaw($requiredLength);
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
}
