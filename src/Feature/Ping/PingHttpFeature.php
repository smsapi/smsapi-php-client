<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Ping;

use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Feature\Ping\Data\Ping;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

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

    /**
     * @return Ping
     * @throws SmsapiClientException
     */
    public function ping(): Ping
    {
        $ping = new Ping();
        $ping->smsapi = false;
        try {
            $this->restRequestExecutor->read('', []);
        } catch (ApiErrorException $apiErrorException) {
            $ping->smsapi = $apiErrorException->getCode() === 404;
        }

        return $ping;
    }
}
