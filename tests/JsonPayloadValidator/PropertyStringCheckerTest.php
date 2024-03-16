<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\IncorrectParametrizationException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueStringTooBigException;
use Utils\JsonPayloadValidator\Exception\ValueStringTooSmallException;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;
use Utils\JsonPayloadValidator\Service\PropertyStringChecker;

class PropertyStringCheckerTest extends TestCase
{
    private PropertyStringChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new PropertyStringChecker(new PropertyPresenceChecker());
    }


    public function shouldPassRequiredDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [$key => 'abc']],
            [$key, [$key => '3']],
        ];
    }

    /**
     * @dataProvider shouldPassRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAStringException
     */
    public function testShouldPassRequired(string $key, array $payload): void
    {
        $this->sut->required($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailRequiredDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [], EntryMissingException::class, "Entry 'myKey' missing"],
            [$key, [$key => ''], EntryEmptyException::class, "Entry 'myKey' empty"],
            [$key, [$key => '    '], EntryEmptyException::class, "Entry 'myKey' empty"],
            [$key, [$key => []], EntryEmptyException::class, "Entry 'myKey' empty"],
            [$key, [$key => 3], ValueNotAStringException::class, "The entry 'myKey' is not a string"],
            [$key, [$key => 3.25], ValueNotAStringException::class, "The entry 'myKey' is not a string"],
            [$key, [$key => false], ValueNotAStringException::class, "The entry 'myKey' is not a string"],
            [$key, [$key => true], ValueNotAStringException::class, "The entry 'myKey' is not a string"],

        ];
    }

    /**
     * @dataProvider shouldFailRequiredDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAStringException
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


    public function shouldPassOptionalDataProvider(): array
    {
        $key = 'myKey';
        return [
            [$key, []],
            [$key, [$key => 'abc']],
            [$key, [$key => null]]
        ];
    }

    /**
     * @dataProvider shouldPassOptionalDataProvider
     * @throws OptionalPropertyNotAStringException
     */
    public function testShouldPassOptional(string $key, array $payload): void
    {
        $this->sut->optional($key, $payload);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailOptionalDataProvider(): array
    {
        $key = 'myKey';
        $msg001 = "The entry 'myKey' is optional, but if provided it should be a string";

        return [
            [$key, [$key => ''], OptionalPropertyNotAStringException::class, $msg001],
            [$key, [$key => '        '], OptionalPropertyNotAStringException::class, $msg001],
            [$key, [$key => 3], OptionalPropertyNotAStringException::class, $msg001],
            [$key, [$key => []], OptionalPropertyNotAStringException::class, $msg001],
        ];
    }

    /**
     * @dataProvider shouldFailOptionalDataProvider
     * @throws OptionalPropertyNotAStringException
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


    public function byteLengthRangeShouldThrowFailValidationDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Negative lengths not allowed, but you specified a minimum length of '-1'";
        $m2 = "Negative lengths not allowed, but you specified a maximum length of '-1'";
        $m3 = "Minimum length cannot be greater or equals than maximum length";
        $m4 = "Entry 'myKey' is expected to be at least 2 bytes long, but it is 1";
        $m5 = "Entry 'myKey' is expected to be 3 bytes long maximum, but it is 4";
        $m6 = "Entry 'myKey' empty";
        $m7 = "The entry 'myKey' is not a string";
        $m8 = "Entry 'myKey' is expected to be 2 bytes long maximum, but it is 3";
        $m9 = "Zero lengths would require the 'optional' validator. Please correct the minimum length";
        $ma = "Zero lengths would require the 'optional' validator. Please correct the maximum length";

        return [
            // These errors are about failure to configure the validator. They are not related to failed validation
            [$key, [$key => 'not relevant'], -1, null, true, IncorrectParametrizationException::class, $m1],
            [$key, [$key => 'not relevant'], null, -1, true, IncorrectParametrizationException::class, $m2],
            [$key, [$key => 'not relevant'], 4, 3, true, IncorrectParametrizationException::class, $m3],
            [$key, [$key => 'not relevant'], 4, 4, true, IncorrectParametrizationException::class, $m3],

            [$key, [$key => 'not relevant'], 0, null, true, IncorrectParametrizationException::class, $m9],
            [$key, [$key => 'not relevant'], 0, null, false, IncorrectParametrizationException::class, $m9],

            [$key, [$key => 'not relevant'], null, 0, true, IncorrectParametrizationException::class, $ma],
            [$key, [$key => 'not relevant'], null, 0, false, IncorrectParametrizationException::class, $ma],

            // The rest are about actual payload validation

            [$key, [$key => ''], 2, 3, false, EntryEmptyException::class, $m6],
            [$key, [$key => ''], 2, 3, true, EntryEmptyException::class, $m6],

            [$key, [$key => '    '], 2, 3, false, EntryEmptyException::class, $m6],
            [$key, [$key => '    '], 2, 3, true, EntryEmptyException::class, $m6],
            [$key, [$key => []], 2, 3, true, EntryEmptyException::class, $m6],

            [$key, [$key => 6], 2, 3, true, ValueNotAStringException::class, $m7],
            [$key, [$key => 6.66], 2, 3, true, ValueNotAStringException::class, $m7],
            [$key, [$key => true], 2, 3, true, ValueNotAStringException::class, $m7],
            [$key, [$key => false], 2, 3, true, ValueNotAStringException::class, $m7],

            [$key, [$key => '1'], 2, 3, true, ValueStringTooSmallException::class, $m4],
            [$key, [$key => '1'], 2, 3, false, ValueStringTooSmallException::class, $m4],
            [$key, [$key => '1'], 2, null, false, ValueStringTooSmallException::class, $m4],
            [$key, [$key => '1'], 2, null, true, ValueStringTooSmallException::class, $m4],

            // Seems like a three char string, but the function will trim trailing and leading spaces
            [$key, [$key => ' 1 '], 2, null, true, ValueStringTooSmallException::class, $m4],

            [$key, [$key => '1111'], 2, 3, true, ValueStringTooBigException::class, $m5],
            [$key, [$key => '1111'], 2, 3, false, ValueStringTooBigException::class, $m5],
            [$key, [$key => '1111'], null, 3, false, ValueStringTooBigException::class, $m5],
            [$key, [$key => '1111'], null, 3, true, ValueStringTooBigException::class, $m5],

            [$key, [$key => '大'], null, 2, true, ValueStringTooBigException::class, $m8],
            [$key, [$key => '大'], null, 2, false, ValueStringTooBigException::class, $m8],
            [$key, [$key => '大'], 1, 2, true, ValueStringTooBigException::class, $m8],
            [$key, [$key => '大'], 1, 2, false, ValueStringTooBigException::class, $m8],
        ];
    }

    /**
     * @dataProvider byteLengthRangeShouldThrowFailValidationDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAStringException
     * @throws IncorrectParametrizationException
     * @throws ValueStringTooBigException
     * @throws ValueStringTooSmallException
     */
    public function testByteLengthRangeShouldFailValidation(
        string $key,
        array $payload,
        ?int $minLength,
        ?int $maximumLength,
        bool $required,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->byteLengthRange($key, $payload, $minLength, $maximumLength, $required);
    }

    public function shouldPassByteLengthRangeDataProvider(): array
    {
        $key = 'myKey';

        return [
            [$key, [$key => null], 1, 2, false],
            [$key, [$key => 'a'], 1, 2, false],
            [$key, [$key => 'a'], 1, 2, true],

            [$key, [$key => 'a'], 1, null, false],
            [$key, [$key => 'a'], 1, null, true],

            [$key, [$key => 'a'], null, 1, false],
            [$key, [$key => 'a'], null, 1, true],

            [$key, [$key => 'aa'], 2, 3, false],
            [$key, [$key => 'aaa'], 2, 3, false],
            [$key, [$key => 'aa'], 2, 3, true],
            [$key, [$key => 'aaa'], 2, 3, true],

            [$key, [$key => '    aaa        '], 2, 3, false],
            [$key, [$key => '    aaa        '], 2, 3, true],

        ];
    }

    /**
     * @dataProvider shouldPassByteLengthRangeDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws IncorrectParametrizationException
     * @throws ValueNotAStringException
     * @throws ValueStringTooBigException
     * @throws ValueStringTooSmallException
     */
    public function testShouldPassByteLengthRange(
        string $key,
        array $payload,
        ?int $minLength,
        ?int $maximumLength,
        bool $required
    ): void {
        $this->sut->byteLengthRange($key, $payload, $minLength, $maximumLength, $required);
        $this->expectNotToPerformAssertions();
    }
}
