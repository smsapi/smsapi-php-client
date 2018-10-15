<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Mapper;

use Psr\Http\Message\RequestInterface;
use Smsapi\Client\Infrastructure\Request\Mapper\RequestMapper;

/**
 * @internal
 */
final class AuthorizationRequestMapper implements RequestMapper
{
    /**
     * @var string
     */
    private $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function map(RequestInterface $request): RequestInterface
    {
        return $request->withHeader('Authorization', 'Bearer ' . $this->token);
    }
}
