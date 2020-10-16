<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Client;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\TransferException as GuzzleTransferException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Infrastructure\Client\Exception\ClientException;
use Smsapi\Client\Infrastructure\Client\Exception\NetworkException;
use Smsapi\Client\Infrastructure\Client\Exception\RequestException;
use Smsapi\Client\SmsapiClient;

/**
 * @internal
 */
class GuzzleClient implements ClientInterface
{
    private $apiToken;
    private $uri;
    private $proxy;

    public function __construct(string $apiToken, string $uri, string $proxy)
    {
        $this->apiToken = $apiToken;
        $this->uri = $uri;
        $this->proxy = $proxy;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $guzzleClient = new Client([
            'base_uri' => $this->createBaseUri(),
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::PROXY => $this->proxy,
            RequestOptions::HEADERS => $this->createHeaders(),
        ]);

        try {
            return $guzzleClient->send($request);
        } catch (GuzzleRequestException $e) {
            throw RequestException::create($request, $e);
        } catch (GuzzleTransferException $e) {
            throw NetworkException::create($request, $e);
        } catch (GuzzleException $e) {
            throw ClientException::create($request, $e);
        }
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
            GuzzleClientInterface::VERSION,
            PHP_VERSION
        );
    }
}