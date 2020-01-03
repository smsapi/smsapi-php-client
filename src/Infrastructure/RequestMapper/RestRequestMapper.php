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
class RestRequestMapper
{
    private $queryFormatter;

    public function __construct(ComplexParametersQueryFormatter $queryFormatter)
    {
        $this->queryFormatter = $queryFormatter;
    }

    public function mapCreate(string $path, array $builtInParameters, array $userParameters = []): Request
    {
        $request = $this->createRequest(RequestHttpMethod::POST, $path, $builtInParameters, $userParameters);

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    public function mapRead(string $path, array $builtInParameters, array $userParameters = []): Request
    {
        $path .= $this->createPathQuery($builtInParameters, $userParameters);

        return $this->createRequest(RequestHttpMethod::GET, $path, []);
    }

    public function mapDelete(string $path, array $builtInParameters, array $userParameters = []): Request
    {
        $path .= $this->createPathQuery($builtInParameters, $userParameters);

        return $this->createRequest(RequestHttpMethod::DELETE, $path, []);
    }

    public function mapUpdate(string $path, array $builtInParameters, array $userParameters = []): Request
    {
        $request = $this->createRequest(RequestHttpMethod::PUT, $path, $builtInParameters, $userParameters);

        return $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    public function mapInfo(string $path, array $builtInParameters, array $userParameters): Request
    {
        $path .= $this->createPathQuery($builtInParameters, $userParameters);

        return $this->createRequest(RequestHttpMethod::HEAD, $path, []);
    }

    private function createPathQuery(array $builtInParameters, array $userParameters): string
    {
        $pathQuery = '';
        if ($builtInParameters || $userParameters) {
            $parameters = new QueryParametersData($builtInParameters, $userParameters);
            $pathQuery .= '?' . $this->queryFormatter->format($parameters);
        }

        return $pathQuery;
    }

    private function createRequest(
        string $method,
        string $path,
        array $builtInParameters,
        array $userParameters = []
    ): Request {
        $parameters = new QueryParametersData($builtInParameters, $userParameters);

        return new Request($method, $path, $this->queryFormatter->format($parameters));
    }
}
