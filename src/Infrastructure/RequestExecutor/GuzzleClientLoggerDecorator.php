<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

class GuzzleClientLoggerDecorator implements ClientInterface
{
    private $client;
    private $logger;

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function send(RequestInterface $request, array $options = [])
    {
        $this->logger->info('Send', ['request' => $request, 'options' => $options]);

        $response = $this->client->send($request, $options);

        $this->logger->info('Send result', ['response' => $response]);

        return $response;
    }

    public function sendAsync(RequestInterface $request, array $options = [])
    {
        $this->logger->info('Send async', ['request' => $request, 'options' => $options]);

        $promise = $this->client->send($request, $options);

        $this->logger->info('Send async result', ['promise' => $promise]);

        return $promise;
    }

    public function request($method, $uri, array $options = [])
    {
        $this->logger->info('Request', ['method' => $method, 'uri' => $uri, 'options' => $options]);

        $response = $this->client->request($method, $uri, $options);

        $this->logger->info('Request result', ['response' => $response]);

        return $response;
    }

    public function requestAsync($method, $uri, array $options = [])
    {
        $this->logger->info('Request async', ['method' => $method, 'uri' => $uri, 'options' => $options]);

        $promise = $this->client->requestAsync($method, $uri, $options);

        $this->logger->info('Request async result', ['promise' => $promise]);

        return $promise;
    }

    public function getConfig($option = null)
    {
        $this->logger->info('Get config', ['option' => $option]);

        $config = $this->client->getConfig($option);

        $this->logger->info('Get config result', ['config' => $config]);

        return $config;
    }
}
