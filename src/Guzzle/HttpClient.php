<?php

declare(strict_types=1);

namespace Smsapi\Client\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\TransferException as GuzzleTransferException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Guzzle\Exception\ClientException;
use Smsapi\Client\Guzzle\Exception\NetworkException;
use Smsapi\Client\Guzzle\Exception\RequestException;

/**
 * @internal
 */
class HttpClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $guzzleClient = new Client([
            RequestOptions::HTTP_ERRORS => false,
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
}