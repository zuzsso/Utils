<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
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
        $m1 = "Entry '$key' missing";
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
}
