<?php

declare(strict_types=1);

namespace Smsapi\Client\Infrastructure\RequestMapper\Query;

/**
 * @internal
 */
class QueryParametersData
{

    /** @var array */
    public $builtInParameters;

    /** @var array */
    public $userParameters;

    public function __construct(array $builtInParameters = [], array $userParameters = [])
    {
        $this->builtInParameters = $builtInParameters;
        $this->userParameters = $userParameters;
    }
}
