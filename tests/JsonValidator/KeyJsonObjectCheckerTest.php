<?php

declare(strict_types=1);

namespace Utils\Tests\JsonValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonValidator\Exception\EntryEmptyException;
use Utils\JsonValidator\Exception\EntryMissingException;
use Utils\JsonValidator\Exception\InvalidJsonObjectValueException;
use Utils\JsonValidator\Service\KeyJsonObjectChecker;
use Utils\JsonValidator\Service\KeyPresenceChecker;

class KeyJsonObjectCheckerTest extends TestCase
{
    private KeyJsonObjectChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new KeyJsonObjectChecker(new KeyPresenceChecker());
    }

    public function shouldFailRequiredDataProvider(): array
    {
        $key = 'myKey';

        $m1 = "Entry 'myKey' missing";
        $m2 = "Entry 'myKey' empty";
        $m3 = "The key 'myKey' is required and must point to a valid JSON object";
        return [
            [$key, [], EntryMissingException::class, $m1],
            [$key, [$key => null], EntryEmptyException::class, $m2],
            [$key, [$key => ''], EntryEmptyException::class, $m2],
            [$key, [$key => []], EntryEmptyException::class, $m2],
            [$key, [$key => [1, 2, 3]], InvalidJsonObjectValueException::class, $m3],
            [$key, [$key => ["a", true, 1.3]], InvalidJsonObjectValueException::class, $m3],
            [$key, [$key => [[], []]], InvalidJsonObjectValueException::class, $m3],
        ];
    }

    /**
     * @dataProvider shouldFailRequiredDataProvider
     * @throws InvalidJsonObjectValueException
     * @throws EntryEmptyException
     * @throws EntryMissingException
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
            [$key, [$key => ['a' => 1]]],
            [$key, [$key => ['a' => 1, 'b' => null, 'c' => true]]]
        ];
    }


    /**
     * @dataProvider shouldPassRequiredDataProvider
     *
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws InvalidJsonObjectValueException
     */
    public function testShouldPassRequired(string $key, array $payload): void
    {
        $this->sut->required($key, $payload);

        $this->expectNotToPerformAssertions();
    }
}