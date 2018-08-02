<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestAssembler;

use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Psr\Http\Message\RequestInterface;
use Smsapi\Client\Infrastructure\Request;

/**
 * @internal
 */
class GuzzleRequestAssembler
{
    public function assemble(Request $request): RequestInterface
    {
        return new GuzzleRequest(
            $request->getMethod(),
            $request->getUri(),
            $request->getHeaders(),
            $request->getBody()
        );
    }
}
