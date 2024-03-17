<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\ValueNotAFloatException;
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
}
