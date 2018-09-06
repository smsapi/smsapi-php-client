<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use function GuzzleHttp\Promise\rejection_for;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\SmsapiClient;

/**
 * @internal
 */
class GuzzleClientFactory
{
    use LoggerAwareTrait;

    private $apiToken;
    private $uri;
    private $proxy;

    public function __construct(string $apiToken, string $uri, string $proxy)
    {
        $this->logger = new NullLogger();
        $this->apiToken = $apiToken;
        $this->uri = $uri;
        $this->proxy = $proxy;
    }

    public function createGuzzle(): ClientInterface
    {
        return new Client(
            [
                'base_uri' => $this->createBaseUri(),
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::PROXY => $this->proxy,
                RequestOptions::HEADERS => $this->createHeaders(),
                'handler' => $this->createHandler(),
            ]
        );
    }

    private function createBaseUri(): string
    {
        return rtrim($this->uri, '/') . '/';
    }

    private function createHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiToken,
            'X-Request-Id' => $this->generateRequestId(),
            'User-Agent' => $this->createUserAgent(),
        ];
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(12));
    }

    private function createUserAgent(): string
    {
        return sprintf(
            'smsapi/php-client:%s;guzzle:%s;php:%s',
            SmsapiClient::VERSION,
            ClientInterface::VERSION,
            PHP_VERSION
        );
    }

    private function createHandler(): HandlerStack
    {
        $handlerStack = HandlerStack::create();
        $handlerStack->push($this->createLoggerMiddleware());

        return $handlerStack;
    }

    private function createLoggerMiddleware(): callable
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                /** @var PromiseInterface $promise */
                $promise = $handler($request, $options);

                return $promise->then(
                    function (ResponseInterface $response) use ($request) {
                        $this->log($request, $response);

                        return $response;
                    },
                    function (PromiseInterface $reason) use ($request) {
                        $response = $reason instanceof RequestException ? $reason->getResponse() : null;

                        $this->log($request, $response);

                        return rejection_for($reason);
                    }
                );
            };
        };
    }

    private function log(RequestInterface $request, ResponseInterface $response = null)
    {
        $statusCode = null;
        $responseCopy = null;
        if ($response) {
            $statusCode = $response->getStatusCode();
            $responseCopy = $this->copyResponse($response);
        }

        $message = sprintf(
            'Request: %s %s HTTP/%s. Response: %s',
            $request->getMethod(),
            $request->getRequestTarget(),
            $request->getProtocolVersion(),
            $statusCode
        );

        $this->logger->info($message, ['request' => $request, 'response' => $responseCopy]);
    }

    private function copyResponse(ResponseInterface $response): ResponseInterface
    {
        $resource = fopen('php://temp', 'r+');
        fwrite($resource, $response->getBody()->__toString());
        $response->getBody()->rewind();
        fseek($resource, 0);
        $options = ['metadata' => $response->getBody()->getMetadata(), 'size' => $response->getBody()->getSize()];
        $body = new Stream($resource, $options);

        return $response->withBody($body);
    }
}
