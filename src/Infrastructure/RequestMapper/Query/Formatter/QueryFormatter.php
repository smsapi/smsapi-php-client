<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter;

use DateTimeInterface;
use Smsapi\Client\Infrastructure\RequestMapper\Query\QueryParametersData;

/**
 * @internal
 */
abstract class QueryFormatter
{
    public function format(QueryParametersData $parameters): string
    {
        $data = $this->getQueryParameters($parameters);
        $values = [];
        foreach ($data as $key => $value) {
            if ($value instanceof DateTimeInterface) {
                $value = $value->format('c');
            }
            $values[$this->formatParameterName($key)] = $value;
        }

        return http_build_query($values, '', '&');
    }

    abstract protected function getQueryParameters(QueryParametersData $parameters): array;

    abstract protected function formatParameterName(string $parameterName): string;
}
