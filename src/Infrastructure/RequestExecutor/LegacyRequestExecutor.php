<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smsapi\Client\Infrastructure\RequestAssembler\RequestAssembler;
use Smsapi\Client\Infrastructure\RequestMapper\LegacyRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\LegacyResponseMapper;
use stdClass;

/**
 * @internal
 */
class LegacyRequestExecutor
{
    private $requestMapper;
    private $client;
    private $legacyResponseMapper;
    private $requestFactory;
    private $streamFactory;

    public function __construct(
        LegacyRequestMapper $requestMapper,
        ClientInterface $client,
        LegacyResponseMapper $legacyResponseMapper,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->requestMapper = $requestMapper;
        $this->client = $client;
        $this->legacyResponseMapper = $legacyResponseMapper;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function request(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->requestMapper->map($path, $builtInParameters, $userParameters);

        $assembledRequest = (new RequestAssembler($this->requestFactory, $this->streamFactory))->assemble($request);

        $response = $this->client->sendRequest($assembledRequest);

        return $this->legacyResponseMapper->map($response);
    }
}
