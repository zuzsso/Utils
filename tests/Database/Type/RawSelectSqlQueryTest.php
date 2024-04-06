<?php

declare(strict_types=1);

namespace Utils\Tests\Database\Type;

use PHPUnit\Framework\TestCase;
use Utils\Database\Exception\UnconstructibleRawSqlQueryException;
use Utils\Database\Service\ParameterNamesFromRawQueryExtractor;
use Utils\Database\Service\PdoParameterNamesChecker;
use Utils\Database\Type\NamedParameterCollection;
use Utils\Database\Type\NativeSelectSqlQuery;
use Utils\Database\UseCase\CheckPdoParameterNames;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;

class RawSelectSqlQueryTest extends TestCase
{
    private ExtractParameterNamesFromRawQuery $extractParameterNamesFromRawQuery;
    private CheckPdoParameterNames $checkPdoParameterNames;

    public function setUp(): void
    {
        parent::setUp();
        $this->checkPdoParameterNames = new PdoParameterNamesChecker();
        $this->extractParameterNamesFromRawQuery = new ParameterNamesFromRawQueryExtractor(
            $this->checkPdoParameterNames
        );
    }

    public function shouldThrowExceptionDataProvider(): array
    {
        $m1 = "Found ';' in the raw text. Multiple queries not allowed";
        $m2 = "Found 1 parameters to be bound in the raw query, but the collection has 0";
        $m3 = "Found 0 parameters to be bound in the raw query, but the collection has 1";
        $m4 = "Found placeholder ':param1' in the raw query but the collection doesn't have ':param1'. Make sure you call \$myCollection->add(...,':param1', 'your value')";
        $m5 = "Only SELECT query types allowed";

        return [
            ['SELECT 1;', null, UnconstructibleRawSqlQueryException::class, $m1],
            ['SELECT 1; SELECT 2', null, UnconstructibleRawSqlQueryException::class, $m1],
            ['SELECT WHERE a = :param1', null, UnconstructibleRawSqlQueryException::class, $m2],
            ['SELECT WHERE a = :param1', [], UnconstructibleRawSqlQueryException::class, $m2],
            ['SELECT', [':param1' => 'value1'], UnconstructibleRawSqlQueryException::class, $m3],
            ['SELECT WHERE a= :param1', [':param2' => 'value2'], UnconstructibleRawSqlQueryException::class, $m4],
            ['UPDATE WHERE a= :param1', [':param1' => 'value1'], UnconstructibleRawSqlQueryException::class, $m5],
            ['DELETE WHERE a= :param1', [':param1' => 'value1'], UnconstructibleRawSqlQueryException::class, $m5],
            ['CREATE WHERE a= :param1', [':param1' => 'value1'], UnconstructibleRawSqlQueryException::class, $m5],
            ['DROP WHERE a= :param1', [':param1' => 'value1'], UnconstructibleRawSqlQueryException::class, $m5]
        ];
    }

    /**
     * @dataProvider shouldThrowExceptionDataProvider
     * @throws UnconstructibleRawSqlQueryException
     * @throws IncorrectParametrizationException
     */
    public function testShouldThrowException(
        string $rawSql,
        ?array $params,
        string $expectedException,
        string $expectedExceptionMessage
    ): void {
        $this->expectException($expectedException);
        $this->expectExceptionMessage($expectedExceptionMessage);

        $namedParams = null;

        if ($params !== null) {
            $namedParams = new NamedParameterCollection();
            foreach ($params as $name => $value) {
                $namedParams->add($this->checkPdoParameterNames, (string)$name, (string)$value);
            }
        }

        new NativeSelectSqlQuery($this->extractParameterNamesFromRawQuery, $rawSql, $namedParams);
    }

    public function shouldConstructCorrectlyDataProvider(): array
    {
        return [
            ['SELECT', null],
//            ['SELECT FROM', null],
//            ['sELect FROM', null],
//            ['SELECT FROM', []],
//            ['sELect FROM', []],
//            ['SELECT FROM WHERE param1 = :param1', [':param1' => 'val1']],
//            ['SELECT FROM WHERE param1 = :param1 and param2 = :param2', [':param1' => 'val1', ':param2' => 'val2']]
        ];
    }

    /**
     * @dataProvider shouldConstructCorrectlyDataProvider
     * @throws IncorrectParametrizationException
     * @throws UnconstructibleRawSqlQueryException
     */
    public function testShouldConstructCorrectly(string $rawSql, ?array $params): void
    {
        $this->expectNotToPerformAssertions();

        $namedParams = null;

        if ($params !== null) {
            $namedParams = new NamedParameterCollection();
            foreach ($params as $name => $value) {
                $namedParams->add($this->checkPdoParameterNames, (string)$name, (string)$value);
            }
        }

        new NativeSelectSqlQuery($this->extractParameterNamesFromRawQuery, $rawSql, $namedParams);
    }
}
