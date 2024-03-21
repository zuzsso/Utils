<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Service\ValueArrayChecker;

class ValueArrayCheckerTest extends TestCase
{
    private ValueArrayChecker $sut;

    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new ValueArrayChecker();
    }

    public function shouldFailArrayOfJsonObjectsDataProvider(): array
    {
        $m1 = "The array is required not to be empty";
        $m2 = "Item index '0' is not a JSON object";
        $m3 = "Item index '1' is not a JSON object";

        $fixedTests = [
            [[], true, RequiredArrayIsEmptyException::class, $m1]
        ];

        $variable = [true, false];

        $variableTests = [];

        foreach ($variable as $v) {
            $variableTests[] = [["blah"], $v, ValueNotAJsonObjectException::class, $m2];

            $variableTests[] = [[1, 2, 3], $v, ValueNotAJsonObjectException::class, $m2];
            $variableTests[] = [['', 2, 3], $v, ValueNotAJsonObjectException::class, $m2];
            $variableTests[] = [['  ', 2, 3], $v, ValueNotAJsonObjectException::class, $m2];
            $variableTests[] = [[1.3, 2, 3], $v, ValueNotAJsonObjectException::class, $m2];
            $variableTests[] = [[null, 2, 3], $v, ValueNotAJsonObjectException::class, $m2];
            $variableTests[] = [[[], 2, 3], $v, ValueNotAJsonObjectException::class, $m3];
        }

        return array_merge($fixedTests, $variableTests);
    }

    /**
     * @dataProvider shouldFailArrayOfJsonObjectsDataProvider
     * @throws ValueNotAnArrayException
     * @throws ValueNotAJsonObjectException
     * @throws RequiredArrayIsEmptyException
     */
    public function testShouldFailArrayOfJsonObjects(
        array $payload,
        bool $required,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->arrayOfJsonObjects($payload, $required);
    }

    public function shouldPassArrayOfJsonObjectsDataProvider(): array
    {
        return [
            [[], false],
            [[[]], false],
            [[[]], true],
        ];
    }

    /**
     * @dataProvider shouldPassArrayOfJsonObjectsDataProvider
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     */
    public function testShouldPassArrayOfJsonObjects(array $payload, bool $required): void
    {
        $this->sut->arrayOfJsonObjects($payload, $required);
        $this->expectNotToPerformAssertions();
    }
}
