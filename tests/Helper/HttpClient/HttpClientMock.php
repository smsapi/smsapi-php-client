<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Helper\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\TransferException as GuzzleTransferException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Guzzle\Exception\ClientException;
use Smsapi\Client\Guzzle\Exception\NetworkException;
use Smsapi\Client\Guzzle\Exception\RequestException;
use Smsapi\Client\Guzzle\GuzzleDiscovery;

class HttpClientMock implements ClientInterface
{
    private $mockHandler;

    public function __construct()
    {
        GuzzleDiscovery::run();

        $this->mockHandler = new MockHandler();
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $guzzleClient = new Client([
            'handler' => HandlerStack::create($this->mockHandler)
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

    public function mockResponse(int $statusCode, string $body)
    {
        $this->mockHandler->append(new Response($statusCode, [], $body));
    }
}