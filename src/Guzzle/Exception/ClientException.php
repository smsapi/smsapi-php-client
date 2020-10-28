<?php

declare(strict_types=1);

namespace Smsapi\Client\Guzzle\Exception;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @api
 */
class ClientException extends \Exception implements ClientExceptionInterface
{
    private $request;

    public static function create(RequestInterface $request, Throwable $previous): self
    {
        $exception = new self($previous->getMessage(), 0, $previous);
        $exception->request = $request;
        return $exception;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}