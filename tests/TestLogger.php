<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class TestLogger implements LoggerInterface
{
    use LoggerTrait;

    public function log($level, $message, array $context = [])
    {
        foreach ($context as $item => $value) {
            if ($value instanceof RequestInterface) {
                $context[$item] = [
                    'headers' => $value->getHeaders(),
                    'uri' => $value->getUri()->__toString(),
                    'method' => $value->getMethod(),
                    'contents' => $value->getBody()->__toString(),
                ];
            } elseif ($value instanceof ResponseInterface) {
                $context[$item] = [
                    'headers' => $value->getHeaders(),
                    'status_code' => $value->getStatusCode(),
                    'contents' => $value->getBody()->__toString(),
                ];
            }
        }

        echo sprintf("[%s] %s (%s)\n", $level, $message, print_r($context));
    }
}
