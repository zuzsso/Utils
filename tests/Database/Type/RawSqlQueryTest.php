<?php

declare(strict_types=1);

namespace Utils\Tests\Database\Type;

use PHPUnit\Framework\TestCase;
use Utils\Database\Exception\UnconstructibleRawSqlQueryException;
use Utils\Database\Service\ParameterNamesFromRawQueryExtractor;
use Utils\Database\Service\PdoParameterNamesChecker;
use Utils\Database\Type\NamedParameterCollection;
use Utils\Database\Type\RawSqlQuery;
use Utils\Database\UseCase\CheckPdoParameterNames;
use Utils\Database\UseCase\ExtractParameterNamesFromRawQuery;
use Utils\JsonValidator\Exception\IncorrectParametrizationException;

class RawSqlQueryTest extends TestCase
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
        $m4 = "Found placeholder ':param1' in the raw query but the collection doesn't have 'param1'. Make sure you call \$myCollection->add(...,':param1', 'your value')";

        return [
            ['SELECT 1;', null, UnconstructibleRawSqlQueryException::class, $m1],
            ['SELECT 1; SELECT 2', null, UnconstructibleRawSqlQueryException::class, $m1],
            ['SELECT WHERE a = :param1', null, UnconstructibleRawSqlQueryException::class, $m2],
            ['SELECT WHERE a = :param1', [], UnconstructibleRawSqlQueryException::class, $m2],
            ['SELECT', [':param1' => 'value1'], UnconstructibleRawSqlQueryException::class, $m3],
            ['SELECT WHERE a= :param1', [':param2' => 'value2'], UnconstructibleRawSqlQueryException::class, $m4],
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

        new RawSqlQuery($this->extractParameterNamesFromRawQuery, $rawSql, $namedParams);
    }
}
