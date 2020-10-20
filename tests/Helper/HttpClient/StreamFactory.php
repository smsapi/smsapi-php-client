<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Helper\HttpClient;

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

class StreamFactory implements StreamFactoryInterface
{
    public function createStream(string $content = ''): StreamInterface
    {
        return Utils::streamFor($content);
    }

    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        throw new \RuntimeException('not implemented');
    }

    public function createStreamFromResource($resource): StreamInterface
    {
        throw new \RuntimeException('not implemented');
    }
}