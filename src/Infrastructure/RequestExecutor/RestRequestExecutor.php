<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use Smsapi\Client\Infrastructure\Request;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
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
    private $requestAssembler;

    public function __construct(
        RestRequestMapper $requestMapper,
        ClientInterface $client,
        RestResponseMapper $restResponseMapper,
        GuzzleRequestAssembler $guzzleRequestAssembler
    ) {
        $this->requestMapper = $requestMapper;
        $this->client = $client;
        $this->restResponseMapper = $restResponseMapper;
        $this->requestAssembler = $guzzleRequestAssembler;
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
        $assembledRequest = $this->requestAssembler->assemble($request);

        $response = $this->client->send($assembledRequest);

        return $this->restResponseMapper->map($response);
    }
}
