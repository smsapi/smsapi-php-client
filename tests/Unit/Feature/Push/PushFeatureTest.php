<?php
declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\Push;

use DateTime;
use Smsapi\Client\Feature\Push\Data\PushApp;
use Smsapi\Client\Feature\Push\Data\PushShipmentDispatchDetails;
use Smsapi\Client\Feature\Push\Data\PushShipmentFallback;
use Smsapi\Client\Feature\Push\Data\PushShipmentPayload;
use Smsapi\Client\Feature\Push\Data\PushShipmentSummary;
use Smsapi\Client\Feature\Push\Bag\SendPushBag;
use Smsapi\Client\Feature\Push\Data\PushShipment;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use Smsapi\Client\Tests\Fixture;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;
use stdClass;
use function theodorejb\polycast\to_float;

/**
 * @deprecated
 */
class PushFeatureTest extends SmsapiClientUnitTestCase
{
    /**
     * @test
     */
    public function it_should_send_push()
    {
        $body = Fixture::getJson('send_push_response');
        $this->mockResponse(ResponseHttpCode::OK, $body);
        $pushShipment = json_decode($body);
        $pushFeature = self::$smsapiService->pushFeature();
        $sendPushBag = new SendPushBag('1', $pushShipment->payload->alert);

        $result = $pushFeature->createPush($sendPushBag);

        $this->assertPushShipment($pushShipment, $result);
    }

    private function assertPushShipment(stdClass $expected, PushShipment $actual)
    {
        $pushShipment = new PushShipment();
        $pushShipment->id = $expected->id;
        $pushShipment->status = $expected->status;
        $pushShipment->dateCreated = new DateTime($expected->date_created);
        $pushShipment->scheduledDate = new DateTime($expected->scheduled_date);

        $pushShipment->app = new PushApp();
        $pushShipment->app->id = $expected->app->id;
        $pushShipment->app->name = $expected->app->name;
        $pushShipment->app->icon = $expected->app->icon;

        $pushShipment->payload = new PushShipmentPayload();
        $pushShipment->payload->alert = $expected->payload->alert;

        $pushShipment->summary = new PushShipmentSummary();
        $pushShipment->summary->points = to_float($expected->summary->points);
        $pushShipment->summary->recipientsCount = $expected->summary->recipients_count;
        $pushShipment->summary->errorCode = $expected->summary->error_code;

        $pushShipment->dispatchDetails = new PushShipmentDispatchDetails();
        $pushShipment->dispatchDetails->channels = $expected->dispatch_details->channels;
        $pushShipment->dispatchDetails->deviceIds = $expected->dispatch_details->device_ids;
        $pushShipment->dispatchDetails->deviceType = $expected->dispatch_details->device_type;

        $pushShipment->fallback = new PushShipmentFallback();
        $pushShipment->fallback->message = $expected->fallback->message;
        $pushShipment->fallback->from = $expected->fallback->from;
        $pushShipment->fallback->delay = $expected->fallback->delay;
        $pushShipment->fallback->status = $expected->fallback->status;

        $this->assertEquals($pushShipment, $actual);
    }
}
