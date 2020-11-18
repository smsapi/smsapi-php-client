<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient\Decorator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class AcceptJsonHeaderDecorator implements ClientInterface
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $request = $this->addAcceptJsonHeader($request);

        return $this->client->sendRequest($request);
    }

    private function addAcceptJsonHeader(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Accept', 'application/json');
    }
}