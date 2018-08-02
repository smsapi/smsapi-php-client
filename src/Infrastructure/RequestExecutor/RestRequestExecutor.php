<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use Smsapi\Client\Infrastructure\Request;
use Smsapi\Client\Infrastructure\RequestAssembler\GuzzleRequestAssembler;
use Smsapi\Client\Infrastructure\RequestMapper\RestRequestMapper;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Infrastructure\ResponseMapper\RestResponseMapper;
use stdClass;

/**
 * @internal
 */
class RestRequestExecutor
{
    private $restRequestMapper;
    private $guzzle;
    private $restResponseMapper;

    /** @var GuzzleRequestAssembler */
    private $requestAssembler;

    public function __construct(
        RestRequestMapper $restRequestMapper,
        ClientInterface $guzzleHttp,
        RestResponseMapper $restResponseMapper,
        GuzzleRequestAssembler $requestAssembler
    ) {
        $this->restRequestMapper = $restRequestMapper;
        $this->guzzle = $guzzleHttp;
        $this->restResponseMapper = $restResponseMapper;
        $this->requestAssembler = $requestAssembler;
    }

    public function create(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        return $this->sendRequestAndMapResponse(
            $this->restRequestMapper->mapCreate($path, $builtInParameters, $userParameters)
        );
    }

    public function read(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        return $this->sendRequestAndMapResponse(
            $this->restRequestMapper->mapRead($path, $builtInParameters, $userParameters)
        );
    }

    public function delete(string $path, array $builtInParameters, array $userParameters = [])
    {
        $this->sendRequestAndMapResponse(
            $this->restRequestMapper->mapDelete($path, $builtInParameters, $userParameters)
        );
    }

    public function update(string $path, array $builtInParameters, array $userParameters = []): stdClass
    {
        return $this->sendRequestAndMapResponse(
            $this->restRequestMapper->mapUpdate($path, $builtInParameters, $userParameters)
        );
    }

    /**
     * @throws ApiErrorException
     */
    private function sendRequestAndMapResponse(Request $request): stdClass
    {
        return $this->restResponseMapper->map($this->guzzle->send($this->requestAssembler->assemble($request)));
    }
}
