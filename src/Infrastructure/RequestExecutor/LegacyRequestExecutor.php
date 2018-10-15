<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestExecutor;

use Psr\Http\Client\ClientInterface;
use Smsapi\Client\Infrastructure\Request\Mapper\AcceptJsonRequestMapper;
use Smsapi\Client\Infrastructure\Request\Mapper\AuthorizationRequestMapper;
use Smsapi\Client\Infrastructure\Request\Mapper\ContentTypeRequestMapper;
use Smsapi\Client\Infrastructure\Request\Mapper\RequestIdRequestMapper;
use Smsapi\Client\Infrastructure\Response\JsonDeserializer;
use Smsapi\Client\Infrastructure\Response\LegacyResponseValidator;

/**
 * @internal
 */
class LegacyRequestExecutor extends RequestExecutor
{
    public function __construct(ClientInterface $client, JsonDeserializer $deserializer, LegacyResponseValidator $responseValidator, string $token)
    {
        parent::__construct(
            $client,
            $deserializer,
            $responseValidator,
            [
                new AcceptJsonRequestMapper(),
                new AuthorizationRequestMapper($token),
                new ContentTypeRequestMapper(),
                new RequestIdRequestMapper()
            ]
        );
    }
}
