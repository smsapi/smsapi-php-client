<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
use Smsapi\Client\Infrastructure\RequestMapper\LegacyRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\LegacyResponseMapper;
use Smsapi\Client\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class LegacyRequestExecutor
{
    private $legacyRequestMapper;
    private $client;
    private $legacyResponseMapper;

    /** @var GuzzleRequestAssembler */
    private $requestAssembler;

    public function __construct(
        LegacyRequestMapper $legacyRequestMapper,
        ClientInterface $client,
        LegacyResponseMapper $legacyResponseMapper,
        GuzzleRequestAssembler $requestAssembler
    ) {
        $this->legacyRequestMapper = $legacyRequestMapper;
        $this->client = $client;
        $this->legacyResponseMapper = $legacyResponseMapper;
        $this->requestAssembler = $requestAssembler;
    }

    /**
     * @param string $path
     * @param array $builtInParameters
     * @param array $userParameters
     * @return stdClass
     * @throws GuzzleException
     * @throws SmsapiClientException
     */
    public function request(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        $request = $this->legacyRequestMapper->map($path, $builtInParameters, $userParameters);
        $response = $this->client->send($this->requestAssembler->assemble($request));

        return $this->legacyResponseMapper->map($response);
    }
}
