<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestMapper\Query\Formatter;

use Smsapi\Client\Infrastructure\RequestMapper\Query\QueryParametersData;

/**
 * @internal
 */
class ComplexParametersQueryFormatter
{

    /** @var BuiltInParametersQueryFormatter */
    private $builtInParametersQueryFormatter;

    /** @var UserParametersQueryFormatter */
    private $userParametersQueryFormatter;

    public function __construct()
    {
        $this->builtInParametersQueryFormatter = new BuiltInParametersQueryFormatter();
        $this->userParametersQueryFormatter = new UserParametersQueryFormatter();
    }

    public function format(QueryParametersData $parameters): string
    {
        $query = '';

        if (!empty($parameters->builtInParameters)) {
            $query = $this->builtInParametersQueryFormatter->format($parameters);
        }

        if (!empty($parameters->userParameters)) {
            if (!empty($query)) {
                $query .= '&';
            }
            $query .= $this->userParametersQueryFormatter->format($parameters);
        }

        return $query;
    }
}
