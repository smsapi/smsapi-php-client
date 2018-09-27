<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Mapper;

use Psr\Http\Message\RequestInterface;
use Smsapi\Client\Infrastructure\Request\Mapper\RequestMapper;

final class AcceptJsonRequestMapper implements RequestMapper
{
    public function map(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Accept', 'application/json');
    }
}
