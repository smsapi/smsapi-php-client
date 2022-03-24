<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Smsapi\Client\Curl\Exception\NetworkException;
use Smsapi\Client\Curl\Exception\RequestException;

/**
 * @internal
 */
class HttpClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $httpClient = $this->prepareRequestHttpClient($request);

        $this->prepareRequestMethod($request, $httpClient);
        $this->prepareRequestBody($request, $httpClient);
        $this->prepareRequestHeaders($request, $httpClient);
        $this->prepareResponseOptions($httpClient);

        $response = $this->execute($request, $httpClient);

        $this->closeHttpClient($httpClient);

        return $response;
    }

    private function prepareRequestHttpClient(RequestInterface $request)
    {
        $url = sprintf("%s://%s%s", $request->getUri()->getScheme(), $request->getUri()->getHost(), $request->getRequestTarget());
        $httpClient = curl_init($url);

        if ($httpClient === false) {
            throw NetworkException::withRequest(
                'Cannot prepare HTTP client: ' . curl_error($httpClient),
                $request
            );
        }

        return $httpClient;
    }

    private function prepareRequestMethod(RequestInterface $request, $httpClient)
    {
        curl_setopt($httpClient, CURLOPT_CUSTOMREQUEST, $request->getMethod());
    }

    private function prepareRequestBody(RequestInterface $request, $httpClient)
    {
        curl_setopt($httpClient, CURLOPT_POSTFIELDS, (string)$request->getBody());
    }

    private function prepareRequestHeaders(RequestInterface $request, $httpClient)
    {
        $headers = [];
        foreach ($request->getHeaders() as $name => $values) {
            $headers[] = $name . ': ' . implode(', ', $values);
        }

        curl_setopt($httpClient, CURLOPT_HTTPHEADER, $headers);
    }

    private function prepareResponseOptions($httpClient)
    {
        curl_setopt($httpClient, CURLOPT_HEADER, true);
        curl_setopt($httpClient, CURLOPT_RETURNTRANSFER, true);
    }

    private function execute(RequestInterface $request, $httpClient): ResponseInterface
    {
        $response = curl_exec($httpClient);

        if ($response === false) {
            throw RequestException::withRequest(
                'Cannot send request: ' . curl_error($httpClient),
                $request
            );
        }

        $responseStatus = curl_getinfo($httpClient, CURLINFO_HTTP_CODE);

        $headerSize = curl_getinfo($httpClient, CURLINFO_HEADER_SIZE);
        $headerString = substr($response, 0, $headerSize);
        $headers = HttpHeadersParser::parse($headerString);

        $body = substr($response, $headerSize);

        return new Response($responseStatus, $headers, $body);
    }

    private function closeHttpClient($httpClient)
    {
        curl_close($httpClient);
    }
}
