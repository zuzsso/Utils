<?php

declare(strict_types=1);

namespace Utils\Tests\EmailAddress\Service;

use PHPUnit\Framework\TestCase;
use Utils\EmailAddress\Service\EmailAddressValidator;

class EmailAddressValidatorTest extends TestCase {
    private EmailAddressValidator $sut;

    public function setUp(): void {
        parent::setUp();
        $this->sut = new EmailAddressValidator();
    }

    /**
     * Basically, it tests emails from https://fightingforalostcause.net/content/misc/2006/compare-email-regex.php
     * @return array
     */
    public function validEmailAddressDataProvider(): array {
        return [
            ['first."mid\dle"."last"@iana.org'],
            ['bob@example.com'],
            ['first.last@x23456789012345678901234567890123456789012345678901234567890123.iana.org'],
            ['my+1@gmail.com'],
            ['dclo@us.ibm.com']
        ];
    }

    /**
     * @param string $emailToTest
     * @return void
     * @dataProvider validEmailAddressDataProvider
     */
    public function testValidEmailAddress(string $emailToTest): void {
        self::assertTrue($this->sut->isValidEmailAddress($emailToTest));
    }

    /**
     * @return array
     */
    public function invalidEmailAddressDataProvider(): array {
        return [

            ['jdoe@machine(comment). example'],
            ['first.(")middle.last(")@iana.org']
        ];
    }

    /**
     * @param string $emailToTest
     * @return void
     * @dataProvider invalidEmailAddressDataProvider
     */
    public function testInvalidEmailAddress(string $emailToTest): void {
        self::assertFalse($this->sut->isValidEmailAddress($emailToTest));
    }
}
