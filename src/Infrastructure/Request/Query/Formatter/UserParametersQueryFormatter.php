<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\Request\Query\Formatter;

use Smsapi\Client\Infrastructure\Request\Query\QueryParametersData;

/**
 * @internal
 */
class UserParametersQueryFormatter extends QueryFormatter
{

    protected function getQueryParameters(QueryParametersData $parameters): array
    {
        return $parameters->userParameters;
    }

    protected function formatParameterName(string $parameterName): string
    {
        return $parameterName;
    }
}
