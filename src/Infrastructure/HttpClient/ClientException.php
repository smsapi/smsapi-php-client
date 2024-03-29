<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\HttpClient;

use Exception;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @api
 */
class ClientException extends Exception implements ClientExceptionInterface
{
    private $request;

    public static function withRequest(string $message, RequestInterface $request): self
    {
        $exception = new static($message);
        $exception->request = $request;

        return $exception;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}