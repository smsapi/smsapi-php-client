<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Helper\HttpClient;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClientRequestSpy implements ClientInterface
{
    private $lastSentRequest;

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->lastSentRequest = $request;

        return new Response();
    }

    public function getLastSentRequest(): RequestInterface
    {
        return $this->lastSentRequest;
    }
}