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


    public function shouldThrowIncorrectParametersExceptionDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Negative lengths not allowed, but you specified a minimum length of '-1'";
        $m2 = "Negative lengths not allowed, but you specified a maximum length of '-1'";
        $m3 = "Minimum length cannot be greater or equals than maximum length";

        return [
            [$key, [$key => 'not relevant'], -1, null, IncorrectParametrizationException::class, $m1],
            [$key, [$key => 'not relevant'], null, -1, IncorrectParametrizationException::class, $m2],
            [$key, [$key => 'not relevant'], 4, 3, IncorrectParametrizationException::class, $m3],
            [$key, [$key => 'not relevant'], 4, 4, IncorrectParametrizationException::class, $m3],
        ];
    }

    /**
     * @dataProvider shouldThrowIncorrectParametersExceptionDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotAStringException
     * @throws IncorrectParametrizationException
     * @throws ValueStringTooBigException
     * @throws ValueStringTooSmallException
     */
    public function testShouldThrowIncorrectParametersException(
        string $key,
        array $payload,
        ?int $minLength,
        ?int $maximumLength,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $this->sut->byteLengthRange($key, $payload, $minLength, $maximumLength);
    }
}
