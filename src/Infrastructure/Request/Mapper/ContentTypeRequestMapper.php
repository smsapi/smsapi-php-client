<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Mapper;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\RequestInterface;
use Smsapi\Client\Infrastructure\Request\Mapper\RequestMapper;

final class ContentTypeRequestMapper implements RequestMapper
{
    const FORM_METHODS = [
        RequestMethodInterface::METHOD_POST,
        RequestMethodInterface::METHOD_PUT
    ];

    public function map(RequestInterface $request): RequestInterface
    {
        if (\in_array($request->getMethod(), self::FORM_METHODS, true)) {
            return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
        }

        return $request;
    }
}
