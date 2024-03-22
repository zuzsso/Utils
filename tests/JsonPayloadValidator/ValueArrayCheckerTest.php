<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
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

    public function shouldFailArrayOfLengthRangeDataProvider(): array
    {
        $m1 = "No range given";
        $m2 = "Zero or negative range is not allowed as min count";
        $m3 = "Values < 1 are not allowed as max count.";
        $m4 = "Range not correctly defined. minCount should be < than max count, strictly";
        $m5 = "Value is meant to be an array of minimum length of 2, but it is 1";
        $m6 = "Value is meant to be an array of maximum length of 1, but it is 2";
        $m7 = "Value is meant to be an array of maximum length of 2, but it is 3";

        return [
            [[], null, null, IncorrectParametrizationException::class, $m1],
            [[], 0, null, IncorrectParametrizationException::class, $m2],
            [[], null, 0, IncorrectParametrizationException::class, $m3],
            [[], 1, 1, IncorrectParametrizationException::class, $m4],
            [[], 2, 1, IncorrectParametrizationException::class, $m4],
            [[[]], 2, null, ValueTooSmallException::class, $m5],
            [[[]], 2, 3, ValueTooSmallException::class, $m5],
            [[[], []], null, 1, ValueTooBigException::class, $m6],
            [[[], [], []], 1, 2, ValueTooBigException::class, $m7],
        ];
    }

    /**
     * @dataProvider shouldFailArrayOfLengthRangeDataProvider
     * @throws IncorrectParametrizationException
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function testShouldFailArrayOfLengthRange(
        array $payload,
        ?int $minLength,
        ?int $maxLength,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->arrayOfLengthRange($payload, $minLength, $maxLength);
    }

    public function shouldPassArrayOfLengthRangeDataProvider(): array
    {
        return [
            [[[]], 1, null],
            [[[], []], 1, null],

            [[[]], null, 3],
            [[[], []], null, 3],
            [[[], [], []], null, 3],

            [[[]], 1, 3],
            [[[], []], 1, 3],
            [[[], [], []], 1, 3],
        ];
    }

    /**
     * @dataProvider shouldPassArrayOfLengthRangeDataProvider
     * @throws IncorrectParametrizationException
     * @throws ValueTooBigException
     * @throws ValueTooSmallException
     */
    public function testShouldPassArrayOfLengthRange(array $payload, ?int $minLength, ?int $maxLength): void
    {
        $this->sut->arrayOfLengthRange($payload, $minLength, $maxLength);
        $this->expectNotToPerformAssertions();
    }
}
