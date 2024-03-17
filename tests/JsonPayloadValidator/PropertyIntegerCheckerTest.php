<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\InvalidIntegerValueException;
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
}
