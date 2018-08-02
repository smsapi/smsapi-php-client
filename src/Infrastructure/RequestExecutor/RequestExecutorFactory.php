<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerAwareTrait;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\ResponseMapper\LegacyResponseMapper;
use Psr\Log\NullLogger;
use Smsapi\Client\Infrastructure\RequestMapper\RestRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\JsonDecode;
use Smsapi\Client\Infrastructure\ResponseMapper\RestResponseMapper;
use Smsapi\Client\Infrastructure\RequestMapper\LegacyRequestMapper;
use Smsapi\Client\SmsapiClient;

/**
 * @internal
 */
class RequestExecutorFactory
{
    use LoggerAwareTrait;

    private $queryFormatter;
    private $restResponseMapper;
    private $legacyResponseMapper;
    private $requestAssembler;
    private $apiToken;
    private $uri;
    private $proxy;

    public function __construct(string $apiToken, string $uri, string $proxy)
    {
        $this->logger = new NullLogger();
        $this->queryFormatter = new ComplexParametersQueryFormatter();
        $jsonDecode = new JsonDecode();
        $this->restResponseMapper = new RestResponseMapper($jsonDecode);
        $this->legacyResponseMapper = new LegacyResponseMapper($jsonDecode);
        $this->requestAssembler = new GuzzleRequestAssembler();
        $this->apiToken = $apiToken;
        $this->uri = $uri;
        $this->proxy = $proxy;
    }

    public function createRestRequestExecutor(): RestRequestExecutor
    {
        $guzzle = $this->createGuzzle();

        return new RestRequestExecutor(
            new RestRequestMapper($this->queryFormatter),
            $guzzle,
            $this->restResponseMapper,
            $this->requestAssembler
        );
    }

    public function createLegacyRequestExecutor(): LegacyRequestExecutor
    {
        $guzzle = $this->createGuzzle();

        return new LegacyRequestExecutor(
            new LegacyRequestMapper($this->queryFormatter),
            $guzzle,
            $this->legacyResponseMapper,
            $this->requestAssembler
        );
    }

    private function createGuzzle(): ClientInterface
    {
        $requestId = uniqid('', true);

        $handlerStack = HandlerStack::create();
        $handlerStack->push(Middleware::log($this->logger, new MessageFormatter()));

        return new Client(
            [
                'handler' => $handlerStack,
                'base_uri' => rtrim($this->uri, '/') . '/',
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::PROXY => $this->proxy,
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'X-Request-Id' => $requestId,
                    'User-Agent' => sprintf(
                        'smsapi/php-client:%s;guzzle:%s;php:%s',
                        SmsapiClient::VERSION,
                        ClientInterface::VERSION,
                        PHP_VERSION
                    ),
                ],
            ]
        );
    }
}
