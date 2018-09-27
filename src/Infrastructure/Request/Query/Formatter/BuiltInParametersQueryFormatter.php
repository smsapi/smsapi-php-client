<?php
declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Query\Formatter;

use Smsapi\Client\Infrastructure\Request\Query\QueryParametersData;

/**
 * @internal
 */
class BuiltInParametersQueryFormatter extends QueryFormatter
{

    protected function getQueryParameters(QueryParametersData $parameters): array
    {
        return $parameters->builtInParameters;
    }

    protected function formatParameterName(string $parameterName): string
    {
        return strtolower(preg_replace('#[A-Z]#', '_$0', $parameterName));
    }
}
