<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push;

use Smsapi\Client\Feature\Push\Bag\SendPushBag;
use Smsapi\Client\Feature\Push\Data\PushShipment;
use Smsapi\Client\Feature\Push\Data\PushShipmentFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class PushHttpFeature implements PushFeature
{
    private $restRequestExecutor;
    private $pushShipmentFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, PushShipmentFactory $pushShipmentFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->pushShipmentFactory = $pushShipmentFactory;
    }

    /**
     * @param SendPushBag $sendPushBag
     * @return PushShipment
     * @throws SmsapiClientException
     */
    public function createPush(SendPushBag $sendPushBag): PushShipment
    {
        $result = $this->restRequestExecutor->create('push', (array)$sendPushBag);

        return $this->pushShipmentFactory->createFromObject($result);
    }
}
