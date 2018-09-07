<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestMapper;

use Smsapi\Client\Infrastructure\Request;
use Smsapi\Client\Infrastructure\RequestHttpMethod;
use Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter\ComplexParametersQueryFormatter;
use Smsapi\Client\Infrastructure\RequestMapper\Query\QueryParametersData;

/**
 * @internal
 */
class LegacyRequestMapper
{
    private $queryFormatter;

    public function __construct(ComplexParametersQueryFormatter $queryFormatter)
    {
        $this->queryFormatter = $queryFormatter;
    }

    public function map(string $path, array $builtInParameters, array $userParameters = []): Request
    {
        $request = $this->createRequest(RequestHttpMethod::POST, $path, $builtInParameters, $userParameters);

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    private function createRequest(
        string $method,
        string $path,
        array $builtInParameters,
        array $userParameters
    ): Request {
        $builtInParameters['format'] = 'json';

        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        return new Request($method, $path, $this->queryFormatter->format($parameters));
    }
}
