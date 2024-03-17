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

        $fixedTests = [
            // Not required, so it doesn't matter that the key isn't there
            [$key, [], $validValues1, false],
            [$key, [$key => null], $validValues1, false],
        ];

        $variable = [true, false];

        $variableTests = [];

        foreach ($variable as $v) {
            $variableTests[] = [$key, [$key => 3], $validValues1, $v];
            $variableTests[] = [$key, [$key => 'a'], $validValues2, $v];
        }

        return array_merge($fixedTests, $variableTests);
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

        $m1 = "Entry 'myKey' missing";
        $m2 = "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '6'";
        $m3 = "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '3'";
        $m4 = "Entry 'myKey' empty";
        $m5 = "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '[[]]'";
        $m6 = "The key 'myKey' can only be one of the following: [1 | 2 | 3], but it is '2.25'";

        $fixedTests = [
            // Required but missing
            [$key, [], $validValues1, true, EntryMissingException::class, $m1],
            [$key, [$key => null], $validValues1, true, EntryEmptyException::class, $m4]
        ];

        $variableTests = [];

        $variables = [true, false];

        foreach ($variables as $v) {
            $variableTests[] = [$key, [$key => 6], $validValues1, $v, ValueNotInListException::class, $m2];
            $variableTests[] = [$key, [$key => "3"], $validValues1, $v, ValueNotInListException::class, $m3];
            $variableTests[] = [$key, [$key => [[]]], $validValues1, $v, ValueNotInListException::class, $m5];
            $variableTests[] = [$key, [$key => 2.25], $validValues1, $v, ValueNotInListException::class, $m6];
        }

        return array_merge($variableTests, $fixedTests);
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
