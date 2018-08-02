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
    public function it_should_create_post_request_with_parameters()
    {
        $path = 'anyPath';

        $builtInParameters = [
            'any1' => 'any',
        ];
        $userParameters = [
            'any2' => 'any',
        ];

        $request = $this->mapper->map($path, $builtInParameters, $userParameters);

        $this->assertEquals($path, $request->getUri());
        $this->assertEquals(RequestHttpMethod::POST, $request->getMethod());

        $this->assertEquals('any1=any&format=json&any2=any', $request->getBody());
    }
}
