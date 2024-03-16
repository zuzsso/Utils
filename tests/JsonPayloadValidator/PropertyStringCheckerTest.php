<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\MissingInputException;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\OptionalPropertyNotAStringException;
use Utils\JsonPayloadValidator\Exception\ValueNotAStringException;
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
}
