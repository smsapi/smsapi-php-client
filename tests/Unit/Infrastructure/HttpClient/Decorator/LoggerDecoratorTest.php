<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\HttpClient\Decorator;

use GuzzleHttp\Psr7\NoSeekStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\AbstractLogger;
use Smsapi\Client\Infrastructure\HttpClient\Decorator\LoggerDecorator;

class LoggerDecoratorTest extends TestCase
{
    /**
     * @test
     */
    public function it_sanitizes_authorization_header()
    {
        $token = 'Bearer my-secret-token-12345';
        $logger = new SpyLogger();
        $client = new StubClient(new Response());
        $decorator = new LoggerDecorator($client, $logger);

        $request = new Request('GET', 'https://example.com', [
            'Authorization' => $token,
        ]);

        $decorator->sendRequest($request);

        $requestLog = $logger->getLog('Request');
        $this->assertArrayHasKey('headers', $requestLog);

        $authHeader = $requestLog['headers']['Authorization'][0];
        $this->assertStringNotContainsString('my-secret-token', $authHeader);
        $this->assertStringStartsWith('xxxx...', $authHeader);
        $this->assertStringContainsString('(len = ' . strlen($token) . ')', $authHeader);
    }

    /**
     * @test
     */
    public function it_preserves_seekable_request_body_after_logging()
    {
        $bodyContent = '{"phone":"123456789"}';
        $logger = new SpyLogger();
        $client = new StubClient(new Response());
        $decorator = new LoggerDecorator($client, $logger);

        $request = new Request('POST', 'https://example.com', [], $bodyContent);

        $decorator->sendRequest($request);

        $requestLog = $logger->getLog('Request');
        $this->assertEquals($bodyContent, $requestLog['body']);

        $sentRequest = $client->getLastRequest();
        $this->assertEquals($bodyContent, (string) $sentRequest->getBody());
    }

    /**
     * @test
     */
    public function it_preserves_seekable_response_body_after_logging()
    {
        $bodyContent = '{"status":"ok"}';
        $logger = new SpyLogger();
        $client = new StubClient(new Response(200, [], $bodyContent));
        $decorator = new LoggerDecorator($client, $logger);

        $request = new Request('GET', 'https://example.com');

        $response = $decorator->sendRequest($request);

        $responseLog = $logger->getLog('Response');
        $this->assertEquals($bodyContent, $responseLog['body']);
        $this->assertEquals($bodyContent, (string) $response->getBody());
    }

    /**
     * @test
     */
    public function it_does_not_consume_non_seekable_request_body()
    {
        $bodyContent = '{"phone":"123456789"}';
        $logger = new SpyLogger();
        $client = new StubClient(new Response());
        $decorator = new LoggerDecorator($client, $logger);

        $nonSeekableStream = new NoSeekStream(Utils::streamFor($bodyContent));
        $request = new Request('POST', 'https://example.com', [], $nonSeekableStream);

        $decorator->sendRequest($request);

        $requestLog = $logger->getLog('Request');
        $this->assertStringContainsString('non-seekable stream', $requestLog['body']);
        $this->assertStringContainsString('size=' . strlen($bodyContent), $requestLog['body']);
    }

    /**
     * @test
     */
    public function it_does_not_consume_non_seekable_response_body()
    {
        $bodyContent = '{"status":"ok"}';
        $logger = new SpyLogger();
        $nonSeekableStream = new NoSeekStream(Utils::streamFor($bodyContent));
        $client = new StubClient(new Response(200, [], $nonSeekableStream));
        $decorator = new LoggerDecorator($client, $logger);

        $request = new Request('GET', 'https://example.com');

        $response = $decorator->sendRequest($request);

        $responseLog = $logger->getLog('Response');
        $this->assertStringContainsString('non-seekable stream', $responseLog['body']);
    }

    /**
     * @test
     */
    public function it_sanitizes_proxy_authorization_header()
    {
        $logger = new SpyLogger();
        $client = new StubClient(new Response());
        $decorator = new LoggerDecorator($client, $logger);

        $request = new Request('GET', 'https://example.com', [
            'Proxy-Authorization' => 'Basic secret',
        ]);

        $decorator->sendRequest($request);

        $requestLog = $logger->getLog('Request');
        $authHeader = $requestLog['headers']['Proxy-Authorization'][0];
        $this->assertStringNotContainsString('secret', $authHeader);
        $this->assertStringStartsWith('xxxx...', $authHeader);
    }

    /**
     * @test
     */
    public function it_does_not_sanitize_regular_headers()
    {
        $logger = new SpyLogger();
        $client = new StubClient(new Response());
        $decorator = new LoggerDecorator($client, $logger);

        $request = new Request('GET', 'https://example.com', [
            'Content-Type' => 'application/json',
            'X-Custom' => 'visible-value',
        ]);

        $decorator->sendRequest($request);

        $requestLog = $logger->getLog('Request');
        $this->assertEquals(['application/json'], $requestLog['headers']['Content-Type']);
        $this->assertEquals(['visible-value'], $requestLog['headers']['X-Custom']);
    }
}

class SpyLogger extends AbstractLogger
{
    private $logs = [];

    public function log($level, $message, array $context = []): void
    {
        $this->logs[(string) $message] = $context;
    }

    public function getLog(string $message): array
    {
        return $this->logs[$message] ?? [];
    }
}

class StubClient implements ClientInterface
{
    private $response;
    private $lastRequest;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->lastRequest = $request;

        return $this->response;
    }

    public function getLastRequest(): RequestInterface
    {
        return $this->lastRequest;
    }
}

