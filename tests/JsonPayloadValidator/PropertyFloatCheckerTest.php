<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\MissingInputException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotAFloatException;
use Utils\JsonPayloadValidator\Exception\ValueNotGreaterThanException;
use Utils\JsonPayloadValidator\Exception\ValueTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueTooSmallException;
use Utils\JsonPayloadValidator\Service\PropertyFloatChecker;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;
use Utils\Math\Numbers\Service\FloatsService;

class PropertyFloatCheckerTest extends TestCase
{
    private PropertyFloatChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new PropertyFloatChecker(
            new PropertyPresenceChecker(),
            new FloatsService()
        );
    }

    public function shouldFailRequiredDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Entry 'myKey' empty";
        $m2 = "Entry 'myKey' missing";
        $m3 = "The entry 'myKey' is required to be a float type, but got an string: 'abc'";
        $m4 = "The entry 'myKey' is required to be a float type, but could not be parsed as such: '1'";
        $m5 = "The entry 'myKey' is required to be a float type, but could not be parsed as such: ''";
        $m6 = "The entry 'myKey' is required to be a float type, but got an string: '1'";
        $m7 = "The entry 'myKey' is required to be a float type";

        return [
            [$key, [], EntryMissingException::class, $m2],

            [$key, [$key => null], EntryEmptyException::class, $m1],
            [$key, [$key => ''], EntryEmptyException::class, $m1],
            [$key, [$key => []], EntryEmptyException::class, $m1],
            [$key, [$key => "abc"], ValueNotAFloatException::class, $m3],
            [$key, [$key => true], ValueNotAFloatException::class, $m4],
            [$key, [$key => false], ValueNotAFloatException::class, $m5],
            [$key, [$key => "1"], ValueNotAFloatException::class, $m6],
            [$key, [$key => [[]]], ValueNotAFloatException::class, $m7],
        ];
    }

    /**
     * @dataProvider shouldFailRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAFloatException
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
            [$key, [$key => 1.3]],
            [$key, [$key => 1]],
        ];
    }

    /**
     * @dataProvider shouldPassRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAFloatException
     */
    public function testShouldPassRequired(string $key, array $payload): void
    {
        $this->sut->required($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailOptionalDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "The entry 'myKey' is optional, but if provided it should be a a float";

        return [
            [$key, [$key => ''], OptionalPropertyNotAFloatException::class, $m1],
            [$key, [$key => []], OptionalPropertyNotAFloatException::class, $m1],
            [$key, [$key => "1"], OptionalPropertyNotAFloatException::class, $m1],
            [$key, [$key => "abc"], OptionalPropertyNotAFloatException::class, $m1],
            [$key, [$key => [[]]], OptionalPropertyNotAFloatException::class, $m1],
            [$key, [$key => true], OptionalPropertyNotAFloatException::class, $m1],
            [$key, [$key => false], OptionalPropertyNotAFloatException::class, $m1],
        ];
    }

    /**
     * @dataProvider shouldFailOptionalDataProvider
     *
     * @throws OptionalPropertyNotAFloatException
     */
    public function testShouldFailOptional(
        string $key,
        array $payload,
        string $expectedException,
        string $expectedExceptionmessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionmessage);
        $this->sut->optional($key, $payload);
    }

    public function shouldPassOptionalDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [$key => null]],
            [$key, [$key => 3]],
            [$key, [$key => 3.25]],
        ];
    }

    /**
     * @dataProvider shouldPassOptionalDataProvider
     * @throws OptionalPropertyNotAFloatException
     */
    public function testShouldPassOptional(string $key, array $payload): void
    {
        $this->sut->optional($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailWithinRangeDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Entry 'myKey' empty";
        $m2 = "Entry 'myKey' missing";
        $m3 = "The entry 'myKey' is required to be a float type, but got an string: '1'";
        $m4 = "The entry 'myKey' is required to be a float type, but got an string: 'abc'";
        $m5 = "The entry 'myKey' is required to be a float type";
        $m6 = "The entry 'myKey' is required to be a float type, but could not be parsed as such: '1'";
        $m7 = "The entry 'myKey' is required to be a float type, but could not be parsed as such: ''";
        $m8 = "Min value cannot be equal or greater than max value";
        $m9 = "No range defined. You may want to use the 'required' function";
        $ma = "Entry 'myKey' is meant to be equals or greater than '3.65': '3.64'";
        $mb = "Entry 'myKey' is meant to be equals or greater than '3.65': '3.64901'";
        $mc = "Entry 'myKey' is meant to be equals or less than '3.65': '3.65001'";
        $md = "Entry 'myKey' is meant to be equals or less than '3.65': '3.66'";

        $fixedTests = [
            [$key, [], 1, 2, true, EntryMissingException::class, $m2],
            [$key, [$key => null], 1, 2, true, EntryEmptyException::class, $m1],
        ];

        $variable = [true, false];

        $variableTests = [];

        foreach ($variable as $v) {
            $variableTests[] = [$key, [$key => 3.25], null, null, $v, IncorrectParametrizationException::class, $m9];
            $variableTests[] = [$key, [$key => 3], 3.65, 3.65, $v, IncorrectParametrizationException::class, $m8];
            $variableTests[] = [$key, [$key => 3], 3.66, 3.65, $v, IncorrectParametrizationException::class, $m8];
            $variableTests[] = [$key, [$key => ''], 1, null, $v, EntryEmptyException::class, $m1];
            $variableTests[] = [$key, [$key => "1"], 1, null, $v, ValueNotAFloatException::class, $m3];
            $variableTests[] = [$key, [$key => "abc"], 1, null, $v, ValueNotAFloatException::class, $m4];
            $variableTests[] = [$key, [$key => [[]]], 1, null, $v, ValueNotAFloatException::class, $m5];
            $variableTests[] = [$key, [$key => true], 1, null, $v, ValueNotAFloatException::class, $m6];
            $variableTests[] = [$key, [$key => false], 1, null, $v, ValueNotAFloatException::class, $m7];
            $variableTests[] = [$key, [$key => 3.64], 3.65, null, $v, ValueTooSmallException::class, $ma];
            $variableTests[] = [$key, [$key => 3.64], 3.65, 3.66, $v, ValueTooSmallException::class, $ma];
            $variableTests[] = [$key, [$key => 3.64901], 3.65, null, $v, ValueTooSmallException::class, $mb];
            $variableTests[] = [$key, [$key => 3.64901], 3.65, 3.66, $v, ValueTooSmallException::class, $mb];
            $variableTests[] = [$key, [$key => 3.65001], null, 3.65, $v, ValueTooBigException::class, $mc];
            $variableTests[] = [$key, [$key => 3.65001], 3.64, 3.65, $v, ValueTooBigException::class, $mc];
            $variableTests[] = [$key, [$key => 3.66], null, 3.65, $v, ValueTooBigException::class, $md];
            $variableTests[] = [$key, [$key => 3.66], 3.64, 3.65, $v, ValueTooBigException::class, $md];
        }

        return array_merge($fixedTests, $variableTests);
    }

    /**
     * @dataProvider shouldFailWithinRangeDataProvider
     *
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws ValueNotAFloatException
     * @throws ValueTooSmallException
     * @throws ValueTooBigException
     */
    public function testShouldFailWithinRange(
        string $key,
        array $payload,
        ?float $minValue,
        ?float $maxValue,
        bool $required,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->withinRange($key, $payload, $minValue, $maxValue, $required);
    }
}
