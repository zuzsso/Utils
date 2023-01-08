<?php

declare(strict_types=1);

namespace Utils\Tests\Files\Service;

use PHPUnit\Framework\TestCase;
use Utils\Files\Service\FileExistsChecker;

class FileExistsCheckerTest extends TestCase {

    private FileExistsChecker $sut;

    public function setUp(): void {
        parent::setUp();
        $this->sut = new FileExistsChecker();
    }

    public function returnsCorrectResultsDataProvider(): array {
        return [
            ['non_existing_file.png', false, false],
            ['non_existing_file.png', true, false],

            [__DIR__, false, false], // Directory, not a file
            [__DIR__, true, false], // Directory, not a file

            // File exists, and it is empty, but requested not to check the file size
            [__DIR__ . '/../FileFixtures/empty.txt', false, true],

            // File exists, and it is empty, but requested to check the file size too
            [__DIR__ . '/../FileFixtures/empty.txt', true, false],

            // File exists, and it is not empty, so it will return true regardless of whether it was requested to
            // check the file size or not
            [__DIR__ . '/../FileFixtures/not_empty.txt', false, true],
            [__DIR__ . '/../FileFixtures/not_empty.txt', true, true],
        ];
    }

    /**
     * @param string $filePath
     * @param bool $checkEmpty
     * @param bool $expected
     * @return void
     * @dataProvider returnsCorrectResultsDataProvider
     */
    public function testReturnsCorrectResults(
        string $filePath,
        bool $checkEmpty,
        bool $expected
    ): void {
        $actual = $this->sut->check($filePath, $checkEmpty);

        self::assertEquals($expected, $actual);
    }
}
