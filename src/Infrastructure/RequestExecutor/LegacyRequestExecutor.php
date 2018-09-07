<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
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
    private $requestAssembler;

    public function __construct(
        LegacyRequestMapper $requestMapper,
        ClientInterface $client,
        LegacyResponseMapper $legacyResponseMapper,
        GuzzleRequestAssembler $requestAssembler
    ) {
        $this->requestMapper = $requestMapper;
        $this->client = $client;
        $this->legacyResponseMapper = $legacyResponseMapper;
        $this->requestAssembler = $requestAssembler;
    }

    public function request(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->requestMapper->map($path, $builtInParameters, $userParameters);

        $assembledRequest = $this->requestAssembler->assemble($request);

        $response = $this->client->send($assembledRequest);

        return $this->legacyResponseMapper->map($response);
    }
}
