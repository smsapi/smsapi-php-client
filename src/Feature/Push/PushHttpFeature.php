<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Push\Bag\SendPushBag;
use Smsapi\Client\Feature\Push\Data\PushShipment;
use Smsapi\Client\Feature\Push\Data\PushShipmentFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class PushHttpFeature implements PushFeature
{
    /**
     * @var RestRequestExecutor
     */
    private $restRequestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $restRequestBuilderFactory;

    /**
     * @var PushShipmentFactory
     */
    private $pushShipmentFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $restRequestBuilderFactory,
        PushShipmentFactory $pushShipmentFactory
    ) {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->restRequestBuilderFactory = $restRequestBuilderFactory;
        $this->pushShipmentFactory = $pushShipmentFactory;
    }

    /**
     * @param SendPushBag $sendPushBag
     * @return PushShipment
     * @throws SmsapiClientException
     */
    public function createPush(SendPushBag $sendPushBag): PushShipment
    {
        $requestBuilder = $this->restRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('push')
            ->withBuiltInParameters((array) $sendPushBag)
            ->get();

        $result = $this->restRequestExecutor->execute($request);

        return $this->pushShipmentFactory->createFromObject($result);
    }
}
