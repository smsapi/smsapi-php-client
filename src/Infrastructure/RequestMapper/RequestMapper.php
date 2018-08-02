<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestMapper;

use Psr\Http\Message\RequestInterface;

interface RequestMapper
{
    public function map(string $path, array $parameters): RequestInterface;
}
