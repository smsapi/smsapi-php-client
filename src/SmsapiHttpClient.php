<?php

declare(strict_types=1);

namespace Smsapi\Client;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Service\SmsapiComHttpService;
use Smsapi\Client\Service\SmsapiPlService;
use Smsapi\Client\Service\SmsapiPlHttpService;

/**
 * @api
 */
class SmsapiHttpClient implements SmsapiClient
{
    use LoggerAwareTrait;

    private $smsapiPlUri = 'https://api.smsapi.pl';
    private $smsapiComUri = 'https://api.smsapi.com';
    private $proxy = '';
    private $dataFactoryProvider;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var UriFactoryInterface
     */
    private $uriFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    public function __construct(
        ClientInterface $client,
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->dataFactoryProvider = new DataFactoryProvider();
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->streamFactory = $streamFactory;

        $this->logger = new NullLogger();
    }

    public function setProxy(string $proxy): SmsapiClient
    {
        $this->proxy = $proxy;

        return $this;
    }

    public function smsapiPlService(string $apiToken): SmsapiPlService
    {
        return $this->smsapiPlServiceWithUri($apiToken, $this->smsapiPlUri);
    }

    public function smsapiPlServiceWithUri(string $apiToken, string $uri): SmsapiPlService
    {
        return new SmsapiPlHttpService(
            $this->createRequestExecutorFactory($apiToken),
            $this->createRestRequestBuilderFactory($uri),
            $this->createLegacyRequestBuilderFactory($uri),
            $this->dataFactoryProvider
        );
    }

    public function smsapiComService(string $apiToken): SmsapiComService
    {
        return $this->smsapiComServiceWithUri($apiToken, $this->smsapiComUri);
    }

    public function smsapiComServiceWithUri(string $apiToken, string $uri): SmsapiComService
    {
        return new SmsapiComHttpService(
            $this->createRequestExecutorFactory($apiToken),
            $this->createRestRequestBuilderFactory($uri),
            $this->createLegacyRequestBuilderFactory($uri),
            $this->dataFactoryProvider
        );
    }

    private function createRequestExecutorFactory(string $apiToken): RequestExecutorFactory
    {
        $requestExecutorFactory = new RequestExecutorFactory($this->client, $apiToken);
        $requestExecutorFactory->setLogger($this->logger);

        return $requestExecutorFactory;
    }

    private function createRestRequestBuilderFactory(string $baseUri): RestRequestBuilderFactory
    {
        return new RestRequestBuilderFactory(
            $this->requestFactory,
            $this->uriFactory,
            $this->streamFactory,
            $baseUri
        );
    }

    private function createLegacyRequestBuilderFactory(string $baseUri): LegacyRequestBuilderFactory
    {
        return new LegacyRequestBuilderFactory(
            $this->requestFactory,
            $this->uriFactory,
            $this->streamFactory,
            $baseUri
        );
    }
}
