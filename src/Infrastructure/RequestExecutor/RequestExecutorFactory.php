<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

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
    private $queryFormatter;
    private $jsonDecode;
    private $requestAssembler;
    private $guzzleClientFactory;

    public function __construct(GuzzleClientFactory $guzzleClientFactory)
    {
        $this->queryFormatter = new ComplexParametersQueryFormatter();
        $this->jsonDecode = new JsonDecode();
        $this->requestAssembler = new GuzzleRequestAssembler();
        $this->guzzleClientFactory = $guzzleClientFactory;
    }

    public function createRestRequestExecutor(): RestRequestExecutor
    {
        $restRequestMapper = new RestRequestMapper($this->queryFormatter);
        $restResponseMapper = new RestResponseMapper($this->jsonDecode);
        $guzzle = $this->guzzleClientFactory->createGuzzle();

        return new RestRequestExecutor($restRequestMapper, $guzzle, $restResponseMapper, $this->requestAssembler);
    }

    public function createLegacyRequestExecutor(): LegacyRequestExecutor
    {
        $legacyRequestMapper = new LegacyRequestMapper($this->queryFormatter);
        $legacyResponseMapper = new LegacyResponseMapper($this->jsonDecode);
        $guzzle = $this->guzzleClientFactory->createGuzzle();

        return new LegacyRequestExecutor($legacyRequestMapper, $guzzle, $legacyResponseMapper, $this->requestAssembler);
    }
}
