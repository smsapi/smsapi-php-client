<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Helper\HttpClient;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClientMock implements ClientInterface
{
    private $responseStatusCode;
    private $responseBody;

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        return new Response($this->responseStatusCode, [], $this->responseBody);
    }

    public function mockResponse(int $responseStatusCode, string $responseBody)
    {
        $this->responseStatusCode = $responseStatusCode;
        $this->responseBody = $responseBody;
    }
}