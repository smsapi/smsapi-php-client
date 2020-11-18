<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestMapper\Query\Formatter;

use DateTime;
use PHPUnit\Framework\TestCase;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\BuiltInParametersQueryFormatter;
use Smsapi\Client\Infrastructure\RequestMapper\Query\QueryParametersData;

class BuiltInParametersQueryFormatterTest extends TestCase
{
    /** @var BuiltInParametersQueryFormatter */
    private $queryFormatter;

    /**
     * @before
     */
    public function init()
    {
        $this->queryFormatter = new BuiltInParametersQueryFormatter();
    }

    /**
     * @test
     */
    public function it_should_add_single_parameter_to_query()
    {
        $builtInParameters = [
            'any' => 'any',
        ];
        $parameters = new QueryParametersData($builtInParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any=any', $query);
    }

    /**
     * @test
     */
    public function it_should_add_many_parameters_to_query()
    {
        $builtInParameters = [
            'any1' => 'any',
            'any2' => 'any',
        ];
        $parameters = new QueryParametersData($builtInParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any1=any&any2=any', $query);
    }

    /**
     * @test
     */
    public function it_should_change_camel_case_parameter_name_to_underscore()
    {
        $builtInParameters = [
            'anyParameter' => 'any',
        ];
        $parameters = new QueryParametersData($builtInParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any_parameter=any', $query);
    }

    /**
     * @test
     */
    public function it_should_format_datetime_values()
    {
        $date = new DateTime();
        $dateEncoded = rawurlencode($date->format('c'));

        $builtInParameters = [
            'any' => $date,
        ];
        $parameters = new QueryParametersData($builtInParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any=' . $dateEncoded, $query);
    }
}
