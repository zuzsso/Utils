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
        $m1 = "Entry 'myKey' missing";
        $m2 = "Entry 'myKey' empty";
        $m3 = "Entry 'myKey' is expected to be an array";
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
}
