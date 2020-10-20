<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Smsapi\Client\Infrastructure\Request;
use Smsapi\Client\Infrastructure\RequestAssembler\RequestAssembler;
use Smsapi\Client\Infrastructure\RequestMapper\RestRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\RestResponseMapper;
use stdClass;

/**
 * @internal
 */
class RestRequestExecutor
{
    private $requestMapper;
    private $client;
    private $restResponseMapper;
    private $requestFactory;
    private $streamFactory;

    public function __construct(
        RestRequestMapper $requestMapper,
        ClientInterface $client,
        RestResponseMapper $restResponseMapper,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->requestMapper = $requestMapper;
        $this->client = $client;
        $this->restResponseMapper = $restResponseMapper;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function create(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->requestMapper->mapCreate($path, $builtInParameters, $userParameters);

        return $this->sendRequestAndMapResponse($request);
    }

    public function read(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->requestMapper->mapRead($path, $builtInParameters, $userParameters);

        return $this->sendRequestAndMapResponse($request);
    }

    public function delete(string $path, array $builtInParameters, array $userParameters = [])
    {
        $this->sendRequestAndMapResponse($this->requestMapper->mapDelete($path, $builtInParameters, $userParameters));
    }

    public function update(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->requestMapper->mapUpdate($path, $builtInParameters, $userParameters);

        return $this->sendRequestAndMapResponse($request);
    }

    public function info(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->requestMapper->mapInfo($path, $builtInParameters, $userParameters);

        return $this->sendRequestAndMapResponse($request);
    }

    private function sendRequestAndMapResponse(Request $request): stdClass
    {
        $assembledRequest = (new RequestAssembler($this->requestFactory, $this->streamFactory))->assemble($request);

        $response = $this->client->sendRequest($assembledRequest);

        return $this->restResponseMapper->map($response);
    }
}
