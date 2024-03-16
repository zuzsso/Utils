<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;

class PropertyPresenceCheckerValidator extends TestCase
{
    private PropertyPresenceChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new PropertyPresenceChecker();
    }

    public function shouldFailRequiredPresenceDataProvider(): array
    {
        $key = 'myKey';

        return [
            [[], $key, EntryMissingException::class, "Entry 'myKey' missing"],
            [['otherKey' => 'value'], $key, EntryMissingException::class, "Entry 'myKey' missing"],
            [[$key => null], $key, EntryEmptyException::class, "Entry 'myKey' empty"],
            [[$key => ''], $key, EntryEmptyException::class, "Entry 'myKey' empty"],
            [[$key => '    '], $key, EntryEmptyException::class, "Entry 'myKey' empty"],
        ];
    }

    /**
     * @dataProvider shouldFailRequiredPresenceDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     */
    public function testShouldFailRequiredPresence(
        array $payloadFixture,
        string $requiredKey,
        string $expectedExceptionClass,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedExceptionClass);
        $this->expectExceptionMessage($expectedExceptionMessage);
        $this->sut->required($requiredKey, $payloadFixture);
    }
}
