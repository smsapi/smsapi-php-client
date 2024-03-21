<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\HttpClient\Decorator;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Smsapi\Client\Infrastructure\HttpClient\Decorator\BaseUriDecorator;
use Smsapi\Client\Tests\Helper\HttpClient\HttpClientRequestSpy;

class BaseUriDecoratorTest extends TestCase
{
    /**
     * @test
     * @testWith
     *  ["https://example.com", "https://example.com/endpoint", "https"]
     *  ["http://example.com", "http://example.com/endpoint", "http"]
     *  ["any://example.com", "any://example.com/endpoint", "any"]
     *  ["any://example.com/base/", "any://example.com/base/endpoint", "any"]
     *  ["any://example.com:80", "any://example.com/endpoint", "any"]
     *  ["any://example.com:80/base/", "any://example.com/base/endpoint", "any"]
     */
    public function send_request_with_base_schema(string $baseUri, string $expectedRequestUri, string $expectedRequestSchema)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals($expectedRequestSchema, $sentRequestSpy->getLastSentRequest()->getUri()->getScheme());
    }

    /**
     * @test
     * @testWith
     *  ["example.com", "example.com/endpoint"]
     *  ["example.com/base/", "example.com/base/endpoint"]
     *  ["example.com:80", "//example.com/endpoint"]
     *  ["example.com:80/base/", "//example.com/base/endpoint"]
     */
    public function send_request_without_base_schema(string $baseUri, string $expectedRequestUri)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals('', $sentRequestSpy->getLastSentRequest()->getUri()->getScheme());
    }

    /**
     * @test
     * @testWith
     *  ["any://example.com", "any://example.com/endpoint", "example.com"]
     *  ["any://example.com:80", "any://example.com/endpoint", "example.com"]
     *  ["any://example", "any://example/endpoint", "example"]
     *  ["any://example:80", "any://example/endpoint", "example"]
     *  ["example.com", "example.com/endpoint", ""]
     *  ["example.com:80", "//example.com/endpoint", "example.com"]
     *  ["example", "example/endpoint", ""]
     *  ["example:80", "//example/endpoint", "example"]
     *  ["example.com/base/", "example.com/base/endpoint", ""]
     *  ["example.com:80/base/", "//example.com/base/endpoint", "example.com"]
     *  ["example/base/", "example/base/endpoint", ""]
     *  ["example:80/base/", "//example/base/endpoint", "example"]
     */
    public function send_request_with_base_host(string $baseUri, string $expectedRequestUri, string $expectedRequestHost)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals($expectedRequestHost, $sentRequestSpy->getLastSentRequest()->getUri()->getHost());
    }

    /**
     * @test
     * @testWith
     *  ["any://", "/endpoint"]
     *  ["any:///", "/endpoint"]
     *  ["any://:80/", "/endpoint"] 
     */
    public function send_request_without_base_host(string $baseUri, string $expectedRequestUri)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals('', $sentRequestSpy->getLastSentRequest()->getUri()->getHost());
    }

    /**
     * @test
     * @testWith
     *  ["any://example.com:80", "any://example.com/endpoint", ""]
     *  ["any://example:80", "any://example/endpoint", ""]
     *  ["example.com:80", "//example.com/endpoint", ""]
     *  ["example:80", "//example/endpoint", ""]
     *  ["example.com:80/base/", "//example.com/base/endpoint", ""]
     *  ["example:80/base/", "//example/base/endpoint", ""]
     */
    public function send_request_with_base_port(string $baseUri, string $expectedRequestUri, string $expectedRequestPort)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals($expectedRequestPort, $sentRequestSpy->getLastSentRequest()->getUri()->getPort());
    }

    /**
     * @test
     * @testWith
     *  ["any://example.com", "any://example.com/endpoint"]
     *  ["any://example", "any://example/endpoint"]
     *  ["any://example.com/base", "any://example.com/base/endpoint"]
     *  ["any://example/base", "any://example/base/endpoint"]
     *  ["example.com", "example.com/endpoint"]
     *  ["example", "example/endpoint"]
     *  ["example.com/base/", "example.com/base/endpoint"]
     *  ["example/base/", "example/base/endpoint"]
     */
    public function send_request_without_base_port(string $baseUri, string $expectedRequestUri)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals('', $sentRequestSpy->getLastSentRequest()->getUri()->getPort());
    }

    /**
     * @test
     * @testWith
     *  ["any://example.com/base", "any://example.com/base/endpoint", "/base/endpoint"]
     *  ["any://example/base", "any://example/base/endpoint", "/base/endpoint"]
     *  ["example.com/base", "example.com/base/endpoint", "example.com/base/endpoint"]
     *  ["example/base", "example/base/endpoint", "example/base/endpoint"]
     *  ["any://example.com:80/base/", "any://example.com/base/endpoint", "/base/endpoint"]
     *  ["any://example:80/base", "any://example/base/endpoint", "/base/endpoint"]
     *  ["example.com:80/base", "//example.com/base/endpoint", "/base/endpoint"]
     *  ["example:80/base", "//example/base/endpoint", "/base/endpoint"]
     *  ["any://example.com/base/", "any://example.com/base/endpoint", "/base/endpoint"]
     *  ["any://example/base/", "any://example/base/endpoint", "/base/endpoint"]
     *  ["example.com/base/", "example.com/base/endpoint", "example.com/base/endpoint"]
     *  ["example/base/", "example/base/endpoint", "example/base/endpoint"]
     *  ["any://example.com:80/base/", "any://example.com/base/endpoint", "/base/endpoint"]
     *  ["any://example:80/base", "any://example/base/endpoint", "/base/endpoint"]
     *  ["example.com:80/base/", "//example.com/base/endpoint", "/base/endpoint"]
     *  ["example:80/base/", "//example/base/endpoint", "/base/endpoint"]
     */
    public function send_request_with_base_path(string $baseUri, string $expectedRequestUri, string $expectedRequestPath)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals($expectedRequestPath, $sentRequestSpy->getLastSentRequest()->getUri()->getPath());
    }

    /**
     * @test
     * @testWith
     *  ["any://example.com", "any://example.com/endpoint", "/endpoint"]
     *  ["any://example", "any://example/endpoint", "/endpoint"]
     *  ["example.com", "example.com/endpoint", "example.com/endpoint"]
     *  ["example", "example/endpoint", "example/endpoint"]
     *  ["any://example.com:80", "any://example.com/endpoint", "/endpoint"]
     *  ["any://example:80", "any://example/endpoint", "/endpoint"]
     *  ["example.com:80", "//example.com/endpoint", "/endpoint"]
     *  ["example:80", "//example/endpoint", "/endpoint"]
     *  ["any://example.com/", "any://example.com/endpoint", "/endpoint"]
     *  ["any://example/", "any://example/endpoint", "/endpoint"]
     *  ["example.com/", "example.com/endpoint", "example.com/endpoint"]
     *  ["example/", "example/endpoint", "example/endpoint"]
     *  ["any://example.com:80/", "any://example.com/endpoint", "/endpoint"]
     *  ["any://example:80/", "any://example/endpoint", "/endpoint"]
     *  ["example.com:80/", "//example.com/endpoint", "/endpoint"]
     *  ["example:80/", "//example/endpoint", "/endpoint"]
     */
    public function send_request_without_base_path(string $baseUri, string $expectedRequestUri, string $expectedRequestPath)
    {
        $sentRequestSpy = new HttpClientRequestSpy();
        $decorator = new BaseUriDecorator($sentRequestSpy, $baseUri);

        $this->sendRequestToAnyEndpoint($decorator);

        $this->assertEquals($expectedRequestUri, (string)$sentRequestSpy->getLastSentRequest()->getUri());
        $this->assertEquals($expectedRequestPath, $sentRequestSpy->getLastSentRequest()->getUri()->getPath());
    }

    private function sendRequestToAnyEndpoint(BaseUriDecorator $decorator)
    {
        $request = new Request('ANY', 'endpoint');
        $decorator->sendRequest($request);
    }
}