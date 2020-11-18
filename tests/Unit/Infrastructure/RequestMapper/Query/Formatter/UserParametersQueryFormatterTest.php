<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestMapper\Query\Formatter;

use DateTime;
use PHPUnit\Framework\TestCase;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\UserParametersQueryFormatter;
use Smsapi\Client\Infrastructure\RequestMapper\Query\QueryParametersData;

class UserParametersQueryFormatterTest extends TestCase
{

    /** @var UserParametersQueryFormatter */
    private $queryFormatter;

    /**
     * @before
     */
    public function init()
    {
        $this->queryFormatter = new UserParametersQueryFormatter();
    }

    /**
     * @test
     */
    public function it_should_add_single_parameter_to_query()
    {
        $userParameters = [
            'any' => 'any',
        ];
        $parameters = new QueryParametersData([], $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any=any', $query);
    }

    /**
     * @test
     */
    public function it_should_add_many_parameters_to_query()
    {
        $userParameters = [
            'any1' => 'any',
            'any2' => 'any',
        ];
        $parameters = new QueryParametersData([], $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any1=any&any2=any', $query);
    }

    /**
     * @test
     */
    public function it_should_not_change_camel_case_parameter_name_to_underscore()
    {
        $userParameters = [
            'anyParameter' => 'any',
        ];
        $parameters = new QueryParametersData([], $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('anyParameter=any', $query);
    }

    /**
     * @test
     */
    public function it_should_format_datetime_values()
    {
        $date = new DateTime();
        $dateEncoded = rawurlencode($date->format('c'));

        $userParameters = [
            'any' => $date,
        ];
        $parameters = new QueryParametersData([], $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any=' . $dateEncoded, $query);
    }
}
