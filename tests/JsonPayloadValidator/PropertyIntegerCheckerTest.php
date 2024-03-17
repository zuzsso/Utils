<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\InvalidIntegerValueException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAnIntegerException;
use Utils\JsonPayloadValidator\Exception\ValueNotGreaterThanException;
use Utils\JsonPayloadValidator\Exception\ValueNotSmallerThanException;
use Utils\JsonPayloadValidator\Service\PropertyIntegerChecker;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;

class PropertyIntegerCheckerTest extends TestCase
{
    private PropertyIntegerChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new PropertyIntegerChecker(new PropertyPresenceChecker());
    }

    public function shouldFailRequiredDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Entry 'myKey' missing";
        $m2 = "Entry 'myKey' empty";

        $m3 = "Entry 'myKey' does not hold a valid int value";

        return [
            [$key, [], EntryMissingException::class, $m1],
            [$key, [$key => null], EntryEmptyException::class, $m2],
            [$key, [$key => []], EntryEmptyException::class, $m2],
            [$key, [$key => ''], EntryEmptyException::class, $m2],
            [$key, [$key => false], InvalidIntegerValueException::class, $m3],
            [$key, [$key => true], InvalidIntegerValueException::class, $m3],
            [$key, [$key => "0"], InvalidIntegerValueException::class, $m3],
            [$key, [$key => "blah"], InvalidIntegerValueException::class, $m3],
            [$key, [$key => 1.25], InvalidIntegerValueException::class, $m3],
            [$key, [$key => [[]]], InvalidIntegerValueException::class, $m3],
        ];
    }

    /**
     * @dataProvider shouldFailRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidIntegerValueException
     */
    public function testShouldFailRequired(
        string $key,
        array $payload,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);
        $this->sut->required($key, $payload);
    }

    public function shouldPassRequiredDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [$key => 1]],
            [$key, [$key => 0]],
            [$key, [$key => -1]]
        ];
    }

    /**
     * @dataProvider shouldPassRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidIntegerValueException
     */
    public function testShouldPassRequired(
        string $key,
        array $payload
    ): void {
        $this->sut->required($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailOptionalDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Entry 'myKey' missing";
        $m2 = "Entry 'myKey' empty";

        $m3 = "Entry 'myKey' does not hold a valid int value";

        return [
            [$key, [$key => null], EntryEmptyException::class, $m2],
            [$key, [$key => []], EntryEmptyException::class, $m2],
            [$key, [$key => ''], EntryEmptyException::class, $m2],
            [$key, [$key => false], InvalidIntegerValueException::class, $m3],
            [$key, [$key => true], InvalidIntegerValueException::class, $m3],
            [$key, [$key => "0"], InvalidIntegerValueException::class, $m3],
            [$key, [$key => "blah"], InvalidIntegerValueException::class, $m3],
            [$key, [$key => 1.25], InvalidIntegerValueException::class, $m3],
            [$key, [$key => [[]]], InvalidIntegerValueException::class, $m3],
        ];
    }

    /**
     * @dataProvider shouldFailOptionalDataProvider
     * @throws InvalidIntegerValueException
     * @throws OptionalPropertyNotAnIntegerException
     */
    public function testShouldFailOptional(
        string $key,
        array $payload,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->optional($key, $payload);
    }

    public function shouldPassOptionalDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, []],
            [$key, [$key => 123]]
        ];
    }

    /**
     * @dataProvider shouldPassOptionalDataProvider
     * @throws InvalidIntegerValueException
     * @throws OptionalPropertyNotAnIntegerException
     */
    public function testShouldPassOptional(string $key, array $payload): void
    {
        $this->sut->optional($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailWithinRangeDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Min value cannot be greater or equal than max value";
        $m2 = "Entry 'myKey' missing";
        $m3 = "Entry 'myKey' empty";
        $m4 = "Entry 'myKey' is meant to be less than '3': '2'";
        $m5 = "Entry 'myKey' does not hold a valid int value";
        $m6 = "Entry 'myKey' is meant to be greater than '5': '6'";

        return [
            [$key, [$key => 123], 4, 4, true, IncorrectParametrizationException::class, $m1],
            [$key, [$key => 123], 4, 4, false, IncorrectParametrizationException::class, $m1],
            [$key, [$key => 123], 5, 4, true, IncorrectParametrizationException::class, $m1],
            [$key, [$key => 123], 5, 4, false, IncorrectParametrizationException::class, $m1],

            [$key, [], null, null, true, EntryMissingException::class, $m2],

            [$key, [$key => null], null, null, true, EntryEmptyException::class, $m3],
            [$key, [$key => ''], null, null, true, EntryEmptyException::class, $m3],
            [$key, [$key => []], null, null, true, EntryEmptyException::class, $m3],

            [$key, [$key => "blah"], null, null, true, InvalidIntegerValueException::class, $m5],
            [$key, [$key => "1"], null, null, true, InvalidIntegerValueException::class, $m5],
            [$key, [$key => true], null, null, true, InvalidIntegerValueException::class, $m5],
            [$key, [$key => false], null, null, true, InvalidIntegerValueException::class, $m5],
            [$key, [$key => [[]]], null, null, true, InvalidIntegerValueException::class, $m5],
            [$key, [$key => 1.1], null, null, true, InvalidIntegerValueException::class, $m5],

            [$key, [$key => "blah"], null, null, false, InvalidIntegerValueException::class, $m5],
            [$key, [$key => "1"], null, null, false, InvalidIntegerValueException::class, $m5],
            [$key, [$key => true], null, null, false, InvalidIntegerValueException::class, $m5],
            [$key, [$key => false], null, null, false, InvalidIntegerValueException::class, $m5],
            [$key, [$key => [[]]], null, null, false, InvalidIntegerValueException::class, $m5],
            [$key, [$key => 1.1], null, null, false, InvalidIntegerValueException::class, $m5],

            [$key, [$key => 2], 3, null, true, ValueNotSmallerThanException::class, $m4],
            [$key, [$key => 2], 3, 5, true, ValueNotSmallerThanException::class, $m4],
            [$key, [$key => 6], null, 5, true, ValueNotGreaterThanException::class, $m6],
            [$key, [$key => 6], 3, 5, true, ValueNotGreaterThanException::class, $m6],

            [$key, [$key => 2], 3, null, false, ValueNotSmallerThanException::class, $m4],
            [$key, [$key => 2], 3, 5, false, ValueNotSmallerThanException::class, $m4],
            [$key, [$key => 6], null, 5, false, ValueNotGreaterThanException::class, $m6],
            [$key, [$key => 6], 3, 5, false, ValueNotGreaterThanException::class, $m6],
        ];
    }

    /**
     * @dataProvider shouldFailWithinRangeDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidIntegerValueException
     * @throws IncorrectParametrizationException
     * @throws ValueNotGreaterThanException
     * @throws ValueNotSmallerThanException
     */
    public function testShouldFailWithinRange(
        string $key,
        array $payload,
        ?int $minValue,
        ?int $maxValue,
        bool $required,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->withinRange($key, $payload, $minValue, $maxValue, $required);
    }
}
