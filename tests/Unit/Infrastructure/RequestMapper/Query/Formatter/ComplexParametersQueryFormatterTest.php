<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestMapper\Query\Formatter;

use DateTime;
use PHPUnit\Framework\TestCase;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\RequestMapper\Query\QueryParametersData;

class ComplexParametersQueryFormatterTest extends TestCase
{
    /** @var ComplexParametersQueryFormatter */
    private $queryFormatter;

    /**
     * @before
     */
    public function init()
    {
        $this->queryFormatter = new ComplexParametersQueryFormatter();
    }

    /**
     * @test
     */
    public function it_should_add_single_parameter_to_query()
    {
        $builtInParameters = [
            'any1' => 'any',
        ];
        $userParameters = [
            'any2' => 'any',
        ];
        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any1=any&any2=any', $query);
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
        $userParameters = [
            'any3' => 'any',
            'any4' => 'any',
        ];
        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any1=any&any2=any&any3=any&any4=any', $query);
    }

    /**
     * @test
     */
    public function it_should_handle_empty_built_in_parameters()
    {
        $builtInParameters = [];
        $userParameters = [
            'any' => 'any',
        ];
        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any=any', $query);
    }

    /**
     * @test
     */
    public function it_should_handle_empty_user_parameters()
    {
        $builtInParameters = [
            'any' => 'any',
        ];
        $userParameters = [];
        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any=any', $query);
    }

    /**
     * @test
     */
    public function it_should_handle_missing_parameters()
    {
        $parameters = new QueryParametersData();

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('', $query);
    }

    /**
     * @test
     */
    public function it_should_handle_missing_user_parameters()
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

        $builtInParameters = [
            'any1' => $date,
        ];
        $userParameters = [
            'any2' => $date,
        ];
        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        $query = $this->queryFormatter->format($parameters);

        $this->assertEquals('any1=' . $dateEncoded . '&any2=' . $dateEncoded, $query);
    }
}
