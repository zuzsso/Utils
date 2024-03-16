<?php

declare(strict_types=1);

namespace Utils\Tests\JsonPayloadValidator;

use PHPUnit\Framework\TestCase;
use Utils\JsonPayloadValidator\Exception\EntryEmptyException;
use Utils\JsonPayloadValidator\Exception\EntryMissingException;
use Utils\JsonPayloadValidator\Exception\ValueNotInListException;
use Utils\JsonPayloadValidator\Service\PropertyCommonChecker;
use Utils\JsonPayloadValidator\Service\PropertyPresenceChecker;

class PropertyCommonCheckerTest extends TestCase
{
    private PropertyCommonChecker $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new PropertyCommonChecker(new PropertyPresenceChecker());
    }

    public function shouldPassValidationDataProvider(): array
    {
        $key = 'myKey';
        $validValues1 = [1, 2, 3];
        $validValues2 = ['a', 'b', 'c'];
        return [
            // Not required, so it doesn't matter that the key isn't there
            [$key, [], $validValues1, false],
            [$key, [$key => null], $validValues1, false],

            [$key, [$key => 3], $validValues1, false],
            [$key, [$key => 3], $validValues1, true],
            [$key, [$key => 'a'], $validValues2, false],
            [$key, [$key => 'b'], $validValues2, true],
        ];
    }

    /**
     * @dataProvider shouldPassValidationDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotInListException
     */
    public function testShouldPassValidation(string $key, array $payload, array $validValues, bool $required): void
    {
        $this->sut->isEnum($key, $payload, $validValues, $required);
        $this->expectNotToPerformAssertions();
    }

    public function shouldFailValidationDataProvider(): array
    {
        $key = 'myKey';
        $validValues1 = [1, 2, 3];
        return [
            // Required but missing
            [$key, [], $validValues1, true, EntryMissingException::class, "Entry 'myKey' missing"],

            // Not required, but once it is provided, it needs to pass validation
            [$key, [$key => 6], $validValues1, false, ValueNotInListException::class, "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '6'"],

            // Should also be checking types. For example, "3" is not the same as 3, even though "3" represents an
            // integer that is in the enum list
            [$key, [$key => "3"], $validValues1, false, ValueNotInListException::class, "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '3'"],

            [$key, [$key => null], $validValues1, true, EntryEmptyException::class, "Entry 'myKey' empty"],

            [$key, [$key => [[]]], $validValues1, true, ValueNotInListException::class, "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '[[]]'"],
            [$key, [$key => [[]]], $validValues1, false, ValueNotInListException::class, "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '[[]]'"],

            [$key, [$key => 2.25], $validValues1, true, ValueNotInListException::class, "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '2.25'"],
            [$key, [$key => 2.25], $validValues1, false, ValueNotInListException::class, "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '2.25'"]
        ];
    }

    /**
     * @dataProvider shouldFailValidationDataProvider
     * @throws EntryEmptyException
     * @throws EntryMissingException
     * @throws ValueNotInListException
     */
    public function testShouldFailValidation(
        string $key,
        array $payload,
        array $validValues,
        bool $required,
        string $expectedException,
        string $expectedMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedMessage);
        $this->sut->isEnum($key, $payload, $validValues, $required);
    }
}
