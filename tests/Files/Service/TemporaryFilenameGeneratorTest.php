<?php

declare(strict_types=1);

namespace Utils\Tests\Files\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Utils\Files\Exception\UnableToGenerateTemporaryFileException;
use Utils\Files\Service\TemporaryFilenameGenerator;
use Utils\Files\Type\FileExtension\Jpg;
use Utils\Files\UseCase\CheckFileExists;

class TemporaryFilenameGeneratorTest extends TestCase {

    /** @var MockObject|CheckFileExists */
    private $fileExistsChecker;

    private TemporaryFilenameGenerator $sut;

    public function setUp(): void {
        parent::setUp();

        $this->fileExistsChecker = $this->createMock(CheckFileExists::class);

        $this->sut = new TemporaryFilenameGenerator($this->fileExistsChecker);
    }

    /**
     * @throws UnableToGenerateTemporaryFileException
     */
    public function testCorrectlyGeneratesFile(): void {

        $this->fileExistsChecker->method('check')->willReturn(false);

        $test = $this->sut->randomNameWithExtensionAndGetFullPath(new Jpg());

        self::assertStringEndsWith('.jpg', $test);
    }

    /**
     * @throws UnableToGenerateTemporaryFileException
     */
    public function testRaisesExceptionIfUnableToGenerate(): void {
        $this->expectException(UnableToGenerateTemporaryFileException::class);
        $this->expectExceptionMessage('Reached max attempts');
        $this->fileExistsChecker->method('check')->willReturn(true);
        $this->sut->randomNameWithExtensionAndGetFullPath(new Jpg());
    }
}
