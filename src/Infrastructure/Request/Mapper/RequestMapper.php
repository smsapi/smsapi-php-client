<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Mapper;

use Psr\Http\Message\RequestInterface;

interface RequestMapper
{
    public function map(RequestInterface $request): RequestInterface;
}