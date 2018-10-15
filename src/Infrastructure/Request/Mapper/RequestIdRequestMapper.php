<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Mapper;

use Psr\Http\Message\RequestInterface;
use Smsapi\Client\Infrastructure\Request\Mapper\RequestMapper;

/**
 * @internal
 */
final class RequestIdRequestMapper implements RequestMapper
{
    public function map(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('X-Request-Id', $this->generateRequestId());
    }

    private function generateRequestId(): string
    {
        return bin2hex(random_bytes(12));
    }
}
