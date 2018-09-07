<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
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
    private $requestAssembler;
    private $guzzleClientFactory;

    public function __construct(GuzzleClientFactory $guzzleClientFactory)
    {
        $this->logger = new NullLogger();
        $this->queryFormatter = new ComplexParametersQueryFormatter();
        $this->jsonDecode = new JsonDecode();
        $this->requestAssembler = new GuzzleRequestAssembler();
        $this->guzzleClientFactory = $guzzleClientFactory;
    }

    public function createRestRequestExecutor(): RestRequestExecutor
    {
        $restRequestMapper = new RestRequestMapper($this->queryFormatter);
        $restResponseMapper = new RestResponseMapper($this->jsonDecode);
        $restResponseMapper->setLogger($this->logger);

        return new RestRequestExecutor(
            $restRequestMapper,
            $this->createGuzzleClient(),
            $restResponseMapper,
            $this->requestAssembler
        );
    }

    public function createLegacyRequestExecutor(): LegacyRequestExecutor
    {
        $legacyRequestMapper = new LegacyRequestMapper($this->queryFormatter);
        $legacyResponseMapper = new LegacyResponseMapper($this->jsonDecode);
        $legacyResponseMapper->setLogger($this->logger);

        return new LegacyRequestExecutor(
            $legacyRequestMapper,
            $this->createGuzzleClient(),
            $legacyResponseMapper,
            $this->requestAssembler
        );
    }

    private function createGuzzleClient(): ClientInterface
    {
        $this->guzzleClientFactory->setLogger($this->logger);
        $guzzle = $this->guzzleClientFactory->createClient();

        return $guzzle;
    }
}
