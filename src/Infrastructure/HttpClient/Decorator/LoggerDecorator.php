<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient\Decorator;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
class LoggerDecorator implements ClientInterface
{
    private $client;
    private $logger;

    public function __construct(ClientInterface $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->logger->info('Request', [
            'method' => $request->getMethod(),
            'uri' => $request->getUri(),
            'headers' => $this->sanitizeHeaders($request->getHeaders()),
            'body' => $this->readBody($request->getBody()),
        ]);

        $response = $this->client->sendRequest($request);

        $this->logger->info('Response', [
            'headers' => $response->getHeaders(),
            'body' => $this->readBody($response->getBody()),
        ]);

        return $response;
    }

    private function readBody(StreamInterface $stream): string
    {
        if ($stream->isSeekable()) {
            $body = (string) $stream;
            $stream->rewind();

            return $body;
        }

        return '<non-seekable stream, size=' . ($stream->getSize() ?? 'unknown') . '>';
    }

    private function sanitizeHeaders(array $headers): array
    {
        $sensitiveHeaders = ['authorization', 'proxy-authorization'];

        foreach ($headers as $name => $values) {
            if (in_array(strtolower($name), $sensitiveHeaders, true)) {
                $headers[$name] = array_map(function (string $value): string {
                    $len = strlen($value);
                    return sprintf('xxxx... (len = %d)', $len);
                }, $values);
            }
        }

        return $headers;
    }
}
