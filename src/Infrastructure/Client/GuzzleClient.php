<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Client;

use GuzzleHttp\Client;
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

/**
 * @internal
 */
class GuzzleClient implements ClientInterface
{
    private $proxy;

    public function __construct(string $proxy)
    {
        $this->proxy = $proxy;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $guzzleClient = new Client([
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

    private function createHeaders(): array
    {
        return [
            'X-Request-Id' => $this->generateRequestId(),
        ];
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(12));
    }
}