<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient\Decorator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 */
class AuthorizationHeaderDecorator implements ClientInterface
{
    private $client;
    private $apiToken;

    public function __construct(ClientInterface $client, string $apiToken)
    {
        $this->client = $client;
        $this->apiToken = $apiToken;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $request = $this->addAuthorizationHeader($request);

        return $this->client->sendRequest($request);
    }

    private function addAuthorizationHeader(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', 'Bearer ' . $this->apiToken);
    }
}