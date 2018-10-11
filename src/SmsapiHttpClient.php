<?php

declare(strict_types=1);

namespace Smsapi\Client;

use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\RequestExecutor\GuzzleClientFactory;
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

    public function __construct()
    {
        $this->dataFactoryProvider = new DataFactoryProvider();
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
            $this->createRequestExecutorFactory($apiToken, $uri),
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
            $this->createRequestExecutorFactory($apiToken, $uri),
            $this->dataFactoryProvider
        );
    }

    private function createRequestExecutorFactory(string $apiToken, string $uri): RequestExecutorFactory
    {
        $guzzleClientFactory = new GuzzleClientFactory($apiToken, $uri, $this->proxy);
        $requestExecutorFactory = new RequestExecutorFactory($guzzleClientFactory);
        $requestExecutorFactory->setLogger($this->logger);

        return $requestExecutorFactory;
    }
}
