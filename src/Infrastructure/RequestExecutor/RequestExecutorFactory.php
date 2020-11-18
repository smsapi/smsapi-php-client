<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Infrastructure\HttpClient\HttpClientFactory;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\ResponseMapper\LegacyResponseMapper;
use Smsapi\Client\Infrastructure\RequestMapper\RestRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\JsonDecode;
use Smsapi\Client\Infrastructure\ResponseMapper\RestResponseMapper;
use Smsapi\Client\Infrastructure\RequestMapper\LegacyRequestMapper;

/**
 * @internal
 */
class RequestExecutorFactory
{
    use LoggerAwareTrait;

    private $queryFormatter;
    private $jsonDecode;
    private $httpClientFactory;
    private $requestFactory;
    private $streamFactory;

    public function __construct(
        HttpClientFactory $httpClientFactory,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->logger = new NullLogger();
        $this->queryFormatter = new ComplexParametersQueryFormatter();
        $this->jsonDecode = new JsonDecode();
        $this->httpClientFactory = $httpClientFactory;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function createRestRequestExecutor(ClientInterface $externalClient): RestRequestExecutor
    {
        $restRequestMapper = new RestRequestMapper($this->queryFormatter);
        $restResponseMapper = new RestResponseMapper($this->jsonDecode);
        $restResponseMapper->setLogger($this->logger);

        return new RestRequestExecutor(
            $restRequestMapper,
            $this->createHttpClient($externalClient),
            $restResponseMapper,
            $this->requestFactory,
            $this->streamFactory
        );
    }

    public function createLegacyRequestExecutor(ClientInterface $externalClient): LegacyRequestExecutor
    {
        $legacyRequestMapper = new LegacyRequestMapper($this->queryFormatter);
        $legacyResponseMapper = new LegacyResponseMapper($this->jsonDecode);
        $legacyResponseMapper->setLogger($this->logger);

        return new LegacyRequestExecutor(
            $legacyRequestMapper,
            $this->createHttpClient($externalClient),
            $legacyResponseMapper,
            $this->requestFactory,
            $this->streamFactory
        );
    }

    private function createHttpClient(ClientInterface $externalHttpClient): ClientInterface
    {
        $this->httpClientFactory->setLogger($this->logger);
        return $this->httpClientFactory->createClient($externalHttpClient);
    }
}
