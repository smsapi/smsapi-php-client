<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\RequestMapper;

use PHPUnit\Framework\TestCase;
use Smsapi\Client\Infrastructure\RequestHttpMethod;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\RequestMapper\RestRequestMapper;

class RestRequestMapperTest extends TestCase
{
    /** @var RestRequestMapper */
    private $mapper;

    /**
     * @before
     */
    public function init()
    {
        $this->mapper = new RestRequestMapper(new ComplexParametersQueryFormatter());
    }

    /**
     * @test
     */
    public function it_should_create_get_request_with_parameters()
    {
        $path = 'anyPath';

        $builtInParameters = [
            'any' => 'any',
        ];

        $request = $this->mapper->mapRead($path, $builtInParameters);

        $this->assertEquals($path . '?any=any', $request->getUri());
        $this->assertEquals(RequestHttpMethod::GET, $request->getMethod());
        $this->assertEquals('', $request->getBody());
    }

    /**
     * @test
     */
    public function it_should_create_post_request_with_parameters()
    {
        $path = 'anyPath';

        $builtInParameters = [
            'any1' => 'any',
        ];
        $userParameters = [
            'any2' => 'any',
        ];

        $request = $this->mapper->mapCreate($path, $builtInParameters, $userParameters);

        $this->assertEquals($path, $request->getUri());
        $this->assertEquals(RequestHttpMethod::POST, $request->getMethod());
        $this->assertEquals('any1=any&any2=any', $request->getBody());
    }

    /**
     * @test
     */
    public function it_should_create_update_request_with_parameters()
    {
        $path = 'anyPath';

        $builtInParameters = [
            'any1' => 'any',
        ];
        $userParameters = [
            'any2' => 'any',
        ];

        $request = $this->mapper->mapUpdate($path, $builtInParameters, $userParameters);

        $this->assertEquals($path, $request->getUri());
        $this->assertEquals(RequestHttpMethod::PUT, $request->getMethod());
        $this->assertEquals('any1=any&any2=any', $request->getBody());
    }

    /**
     * @test
     */
    public function it_should_create_delete_request_with_parameters()
    {
        $path = 'anyPath';

        $builtInParameters = [
            'any' => 'any',
        ];

        $request = $this->mapper->mapDelete($path, $builtInParameters);

        $this->assertEquals($path . '?any=any', $request->getUri());
        $this->assertEquals(RequestHttpMethod::DELETE, $request->getMethod());
        $this->assertEquals('', $request->getBody());
    }
}
