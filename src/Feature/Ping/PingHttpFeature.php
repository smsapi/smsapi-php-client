<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Ping;

use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Feature\Ping\Data\Ping;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class PingHttpFeature implements PingFeature
{
    private $restRequestExecutor;

    public function __construct(RestRequestExecutor $restRequestExecutor)
    {
        $this->restRequestExecutor = $restRequestExecutor;
    }

    public function ping(): Ping
    {
        $ping = new Ping();
        try {
            $this->restRequestExecutor->info('ping', []);
            $ping->smsapi = true;
        } catch (ApiErrorException $apiErrorException) {
            $ping->smsapi = false;
        }

        return $ping;
    }
}
