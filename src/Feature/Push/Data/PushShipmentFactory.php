<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class PushShipmentFactory
{
    private $appFactory;
    private $payloadFactory;
    private $summaryFactory;
    private $detailsFactory;
    private $fallbackFactory;

    public function __construct(
        PushAppFactory $appFactory,
        PushShipmentPayloadFactory $payloadFactory,
        PushShipmentSummaryFactory $summaryFactory,
        PushShipmentDispatchDetailsFactory $detailsFactory,
        PushShipmentFallbackFactory $fallbackFactory
    ) {
        $this->appFactory = $appFactory;
        $this->payloadFactory = $payloadFactory;
        $this->summaryFactory = $summaryFactory;
        $this->detailsFactory = $detailsFactory;
        $this->fallbackFactory = $fallbackFactory;
    }

    public function createFromObject(stdClass $object): PushShipment
    {
        $pushShipment = new PushShipment();
        $pushShipment->id = $object->id;
        $pushShipment->status = $object->status;
        $pushShipment->dateCreated = new DateTime($object->date_created);
        $pushShipment->scheduledDate = new DateTime($object->scheduled_date);
        $pushShipment->app = $this->appFactory->createFromObject($object->app);
        $pushShipment->payload = $this->payloadFactory->createFromObject($object->payload);
        $pushShipment->summary = $this->summaryFactory->createFromObject($object->summary);
        $pushShipment->dispatchDetails = $this->detailsFactory->createFromObject($object->dispatch_details);
        $pushShipment->fallback = $this->fallbackFactory->createFromObject($object->fallback);

        return $pushShipment;
    }
}
