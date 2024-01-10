<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestMapper;

use PHPUnit\Framework\TestCase;
use Smsapi\Client\Infrastructure\RequestHttpMethod;
use Smsapi\Client\Infrastructure\RequestMapper\LegacyRequestMapper;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;

class LegacyRequestMapperTest extends TestCase
{
    /** @var LegacyRequestMapper */
    private $mapper;

    /**
     * @before
     */
    public function init()
    {
        $this->mapper = new LegacyRequestMapper(new ComplexParametersQueryFormatter());
    }

    /**
     * @test
     */
    public function it_should_use_path_as_request_uri()
    {
        $path = 'anyPath';

        $request = $this->mapper->map($path, []);

        $this->assertEquals($path, $request->getUri());
    }

    /**
     * @test
     */
    public function it_should_send_request_as_post()
    {
        $request = $this->mapper->map('anyPath', []);

        $this->assertEquals(RequestHttpMethod::POST, $request->getMethod());
    }

    /**
     * @test
     */
    public function it_should_always_set_format_json_parameter()
    {
        $builtInParameters = [];
        $userParameters = [];

        $request = $this->mapper->map('anyPath', $builtInParameters, $userParameters);

        $this->assertEquals('format=json', $request->getBody());
    }

    /**
     * @test
     */
    public function it_should_prepend_format_parameter_to_built_in_parameters_when_none()
    {
        $builtInParameters = [];
        $userParameters = ['any2' => 'any'];

        $request = $this->mapper->map('anyPath', $builtInParameters, $userParameters);

        $this->assertEquals('format=json&any2=any', $request->getBody());
    }

    /**
     * @test
     */
    public function it_should_prepend_format_parameter_to_built_in_parameters_when_set()
    {
        $builtInParameters = ['any1' => 'any'];
        $userParameters = [];

        $request = $this->mapper->map('anyPath', $builtInParameters, $userParameters);

        $this->assertEquals('format=json&any1=any', $request->getBody());
    }

    /**
     * @test
     */
    public function it_should_merge_both_built_in_and_user_parameters()
    {
        $builtInParameters = [
            'any1' => 'any',
        ];
        $userParameters = [
            'any2' => 'any',
        ];

        $request = $this->mapper->map('anyPath', $builtInParameters, $userParameters);

        $this->assertEquals('format=json&any1=any&any2=any', $request->getBody());
    }
}
