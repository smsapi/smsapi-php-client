<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\SmsapiClient;

/**
 * @internal
 */
class GuzzleClientFactory
{
    use LoggerAwareTrait;

    private $apiToken;
    private $uri;
    private $proxy;

    public function __construct(string $apiToken, string $uri, string $proxy)
    {
        $this->logger = new NullLogger();
        $this->apiToken = $apiToken;
        $this->uri = $uri;
        $this->proxy = $proxy;
    }

    public function createClient(): ClientInterface
    {
        $client = new Client(
            [
                'base_uri' => $this->createBaseUri(),
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::PROXY => $this->proxy,
                RequestOptions::HEADERS => $this->createHeaders(),
            ]
        );

        return new GuzzleClientLoggerDecorator($client, $this->logger);
    }

    private function createBaseUri(): string
    {
        return rtrim($this->uri, '/') . '/';
    }

    private function createHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiToken,
            'X-Request-Id' => $this->generateRequestId(),
            'User-Agent' => $this->createUserAgent(),
        ];
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(12));
    }

    private function createUserAgent(): string
    {
        return sprintf(
            'smsapi/php-client:%s;guzzle:%s;php:%s',
            SmsapiClient::VERSION,
            ClientInterface::VERSION,
            PHP_VERSION
        );
    }
}
