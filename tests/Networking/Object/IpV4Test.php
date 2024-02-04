<?php

declare(strict_types=1);

namespace Utils\Tests\Networking\Object;

use LogicException;
use PHPUnit\Framework\TestCase;
use Utils\Networking\Object\IpV4;

class IpV4Test extends TestCase
{
    public function correctlyBuildsObjectDataProvider(): array
    {
        return [
            ['10.1.2.3'],
            ['255.255.255.255'],
            ['0.0.0.0'],
            ['127.0.0.1']
        ];
    }

    /**
     * @dataProvider correctlyBuildsObjectDataProvider
     * @param string $fixture
     */
    public function testCorrectlyBuildsObject(string $fixture): void
    {
        $sut = IpV4::constructFromString($fixture);

        self::assertEquals($fixture, $sut->__toString());
    }

    public function correctlyFailsBuildingObjectDataProvider(): array
    {
        return [
            ['', "Unrecognized IP V4 address: ''"],
            ['test', "Unrecognized IP V4 address: 'test'"],
            ['0', "Unrecognized IP V4 address: '0'"],
            ['0.00.000.0000', "Unrecognized IP V4 address: '0.00.000.0000'"],
            ['1.2.3.4.5', "Unrecognized IP V4 address: '1.2.3.4.5'"],
            ['192,168,0,25', "Unrecognized IP V4 address: '192,168,0,25'"],
            ['127. 0. 0. 1', "Unrecognized IP V4 address: '127. 0. 0. 1'"],
            ['-125.0.0.1', "Unrecognized IP V4 address: '-125.0.0.1'"],
            ['256.0.0.1', "Unrecognized IP V4 address: '256.0.0.1'"],
            ['0.-255.0.1', "Unrecognized IP V4 address: '0.-255.0.1'"],
            ['0.256.0.1', "Unrecognized IP V4 address: '0.256.0.1'"],
            ['0.0.-3.1', "Unrecognized IP V4 address: '0.0.-3.1'"],
            ['0.0.256.1', "Unrecognized IP V4 address: '0.0.256.1'"],
            ['0.0.0.-3', "Unrecognized IP V4 address: '0.0.0.-3'"],
            ['0.0.0.256', "Unrecognized IP V4 address: '0.0.0.256'"],
            ['1a.0.0.255', "Unrecognized IP V4 address: '1a.0.0.255'"],
            ['a1.0.0.255', "Unrecognized IP V4 address: 'a1.0.0.255'"],
        ];
    }

    /**
     * @param string $fixture
     * @param string $exceptionMessage
     * @dataProvider correctlyFailsBuildingObjectDataProvider
     */
    public function testCorrectlyFailsBuildingObject(string $fixture, string $exceptionMessage): void
    {
        $this->expectExceptionMessage($exceptionMessage);
        $this->expectException(LogicException::class);

        IpV4::constructFromString($fixture);
    }

    public function correctlyComparesIpV4DataProvider(): array
    {
        return [
            ['127.1.2.3', '127.1.2.3', true],
            ['127.1.2.3', '127.255.2.3', false],
            ['127.1.2.3', '127.1.255.3', false],
            ['127.1.2.3', '127.1.2.255', false],
            ['127.1.2.3', '3.1.2.3', false],
        ];
    }

    /**
     * @param string $ip1AsString
     * @param string $ip2AsString
     * @param bool $expected
     * @return void
     * @dataProvider correctlyComparesIpV4DataProvider
     */
    public function testCorrectlyComparesIpV4(string $ip1AsString, string $ip2AsString, bool $expected): void
    {
        $ip1 = IpV4::constructFromString($ip1AsString);
        $ip2 = IpV4::constructFromString($ip2AsString);

        self::assertEquals($expected, $ip1->equalsTo($ip2));

        // Idempotent
        self::assertEquals($expected, $ip2->equalsTo($ip1));
    }
}
