<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\ArrayDoesNotHaveMinimumElementCountException;
use Utils\JsonPayloadValidator\Exception\ArrayExceedsMaximumnAllowedNumberOfElementsException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\ValueNotAJsonObjectException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\RequiredArrayIsEmptyException;
use Utils\JsonPayloadValidator\Exception\ValueNotAnArrayException;
use Utils\JsonPayloadValidator\Service\PropertyArrayChecker;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;

class PropertyArrayCheckerTest extends TestCase
{
    private PropertyArrayChecker $sut;

    public function setUp(): void
    {
        parent::setUp();

        $this->sut = new PropertyArrayChecker(new PropertyPresenceChecker());
    }

    public function shouldFailRequiredDataProvider(): array
    {
        $key = 'myKey';
        $m1 = "Entry '$key' missing";
        $m2 = "Entry '$key' empty";
        $m3 = "Entry '$key' is expected to be an array";
        $m4 = "Associative arrays not supported";
        $m5 = "The first key of this array is not 0";
        $m6 = "The last key is expected to be 1, but it is 2";

        return [
            [$key, [], EntryMissingException::class, $m1],
            [$key, [$key => ''], EntryEmptyException::class, $m2],
            [$key, [$key => '   '], EntryEmptyException::class, $m2],
            [$key, [$key => []], EntryEmptyException::class, $m2],
            [$key, [$key => null], EntryEmptyException::class, $m2],

            [$key, [$key => 0], ValueNotAnArrayException::class, $m3],
            [$key, [$key => "blah"], ValueNotAnArrayException::class, $m3],
            [$key, [$key => true], ValueNotAnArrayException::class, $m3],
            [$key, [$key => false], ValueNotAnArrayException::class, $m3],
            [$key, [$key => 3.25], ValueNotAnArrayException::class, $m3],

            [$key, [$key => [0 => "a", "test" => "b"]], ValueNotAnArrayException::class, $m4],

            [$key, [$key => [1 => "a", 2 => "b"]], ValueNotAnArrayException::class, $m5],
            [$key, [$key => [0 => "a", 2 => "b"]], ValueNotAnArrayException::class, $m6],
        ];
    }

    /**
     * @dataProvider shouldFailRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     */
    public function testShouldFailRequiredKey(
        string $key,
        array $payload,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->requiredKey($key, $payload);
    }

    public function shouldPassRequiredDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [$key => [[]]]],
            [$key, [$key => ["a", "b"]]],
            [$key, [$key => ["a", 1, true, 1.3, false]]],
        ];
    }

    /**
     * @dataProvider shouldPassRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     */
    public function testShouldPassRequiredKey(string $key, array $payload): void
    {
        $this->sut->requiredKey($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailOptionalKeyDataProvider(): array
    {
        $key = 'myKey';
        $m2 = "Entry '$key' empty";
        $m3 = "Entry '$key' is expected to be an array";
        $m4 = "Associative arrays not supported";
        $m5 = "The first key of this array is not 0";
        $m6 = "The last key is expected to be 1, but it is 2";

        return [
            [$key, [$key => ''], EntryEmptyException::class, $m2],
            [$key, [$key => '   '], EntryEmptyException::class, $m2],

            [$key, [$key => 0], ValueNotAnArrayException::class, $m3],
            [$key, [$key => "blah"], ValueNotAnArrayException::class, $m3],
            [$key, [$key => true], ValueNotAnArrayException::class, $m3],
            [$key, [$key => false], ValueNotAnArrayException::class, $m3],
            [$key, [$key => 3.25], ValueNotAnArrayException::class, $m3],

            [$key, [$key => [0 => "a", "test" => "b"]], ValueNotAnArrayException::class, $m4],

            [$key, [$key => [1 => "a", 2 => "b"]], ValueNotAnArrayException::class, $m5],
            [$key, [$key => [0 => "a", 2 => "b"]], ValueNotAnArrayException::class, $m6],
        ];
    }

    /**
     * @dataProvider shouldFailOptionalKeyDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     */
    public function testShouldFailOptionalKey(
        string $key,
        array $payload,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->optionalKey($key, $payload);
    }

    public function shouldPassOptionalKeyDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, []],
            [$key, [$key => null]],
            [$key, [$key => []]],
            [$key, [$key => [[]]]],

        ];
    }

    /**
     * @dataProvider shouldPassOptionalKeyDataProvider
     * @dataProvider shouldPassRequiredDataProvider
     *
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAnArrayException
     */
    public function testShouldPassOptionalKey(string $key, array $payload): void
    {
        $this->sut->optionalKey($key, $payload);
        $this->expectNotToPerformAssertions();
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

    public function shouldFailKeyOfJsonObjectsDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Entry 'myKey' missing";
        $m2 = "Entry 'myKey' empty";
        $m3 = "Entry 'myKey' is expected to be an array";
        $m4 = "Item index '0' is not a JSON object";
        $m5 = "Item index '1' is not a JSON object";

        $fixedTests = [
            [$key, [], true, EntryMissingException::class, $m1],
            [$key, [$key => null], true, EntryEmptyException::class, $m2]
        ];

        $variable = [true, false];

        $variableTests = [];

        foreach ($variable as $v) {
            $variableTests[] = [$key, [$key => []], $v, EntryEmptyException::class, $m2];
            $variableTests[] = [$key, [$key => 'a'], $v, ValueNotAnArrayException::class, $m3];
            $variableTests[] = [$key, [$key => '  '], $v, EntryEmptyException::class, $m2];
            $variableTests[] = [$key, [$key => 1], $v, ValueNotAnArrayException::class, $m3];
            $variableTests[] = [$key, [$key => [1, 2, 3]], $v, ValueNotAJsonObjectException::class, $m4];
            $variableTests[] = [$key, [$key => [[], 2, 3]], $v, ValueNotAJsonObjectException::class, $m5];
        }

        return array_merge($fixedTests, $variableTests);
    }

    /**
     * @dataProvider shouldFailKeyOfJsonObjectsDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     */
    public function testShouldFailKeyOfJsonObjects(
        string $key,
        array $payload,
        bool $required,
        string $expectedException,
        string $expectedExceptionmessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionmessage);
        $this->sut->keyArrayOfJsonObjects($key, $payload, $required);
    }


    public function shouldPassKeyOfJsonObjectsDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [], false],
            [$key, [$key => null], false],
            [$key, [$key => [[]]], true]
        ];
    }

    /**
     * @dataProvider shouldPassKeyOfJsonObjectsDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws RequiredArrayIsEmptyException
     * @throws ValueNotAJsonObjectException
     * @throws ValueNotAnArrayException
     */
    public function testShouldPassKeyOfJsonObjects(
        string $key,
        array $payload,
        bool $required = true
    ): void {
        $this->sut->keyArrayOfJsonObjects($key, $payload, $required);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailKeyArrayOfLengthRangeDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "No range given";
        $m2 = "Range not correctly defined. minCount should be < than max count, strictly";
        $m3 = "Zero or negative range is not allowed as min count.";
        $m4 = "Values < 1 are not allowed as max count.";
        $m5 = "Entry 'myKey' missing";
        $m6 = "Entry 'myKey' empty";

        return [
            [$key, [], null, null, true, IncorrectParametrizationException::class, $m1],

            [$key, [], 2, 1, true, IncorrectParametrizationException::class, $m2],
            [$key, [], 2, 2, true, IncorrectParametrizationException::class, $m2],

            [$key, [], -1, 2, true, IncorrectParametrizationException::class, $m3],
            [$key, [], 0, 2, true, IncorrectParametrizationException::class, $m3],

            [$key, [], null, 0, true, IncorrectParametrizationException::class, $m4],

            [$key, [], 1, null, true, EntryMissingException::class, $m5],
            [$key, [$key => null], 1, null, true, EntryEmptyException::class, $m6]
        ];
    }

    /**
     * @dataProvider shouldFailKeyArrayOfLengthRangeDataProvider
     *
     * @throws ArrayDoesNotHaveMinimumElementCountException
     * @throws ArrayExceedsMaximumnAllowedNumberOfElementsException
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws ValueNotAnArrayException
     */
    public function testShouldFailKeyArrayOfLengthRange(
        string $key,
        array $payload,
        ?int $minCount,
        ?int $maxCount,
        bool $required,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->keyArrayOfLengthRange($key, $payload, $minCount, $maxCount, $required);
    }
}
