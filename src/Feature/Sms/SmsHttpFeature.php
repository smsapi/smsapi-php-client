<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms;

use Psr\Http\Client\ClientInterface;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Sms\Bag\DeleteScheduledSmssBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmssBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmssBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Data\Sms;
use Smsapi\Client\Feature\Sms\Sendernames\SendernamesFeature;
use Smsapi\Client\Feature\Sms\Sendernames\SendernamesHttpFeature;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class SmsHttpFeature implements SmsFeature
{
    private $externalHttpClient;
    private $requestExecutorFactory;
    private $dataFactoryProvider;

    public function __construct(
        ClientInterface $externalHttpClient,
        RequestExecutorFactory $requestExecutorFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->externalHttpClient = $externalHttpClient;
        $this->requestExecutorFactory = $requestExecutorFactory;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function sendernameFeature(): SendernamesFeature
    {
        return new SendernamesHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor($this->externalHttpClient),
            $this->dataFactoryProvider->provideSendernameFactory()
        );
    }

    public function sendSms(SendSmsBag $sendSmsBag): Sms
    {
        $sendSmsBag->details = true;

        $response = $this->makeRequest($sendSmsBag);

        return $this->dataFactoryProvider->provideSmsFactory()->createFromObjectWithDetails(
            current($response->list),
            $response->message,
            $response->length,
            $response->parts
        );
    }

    /**
     * @param SendSmsBag $sendSmsBag
     * @return Sms
     * @throws SmsapiClientException
     */
    public function sendFlashSms(SendSmsBag $sendSmsBag): Sms
    {
        $sendSmsBag->flash = true;
        $sendSmsBag->details = true;

        $response = $this->makeRequest($sendSmsBag);

        return $this->dataFactoryProvider->provideSmsFactory()->createFromObjectWithDetails(
            current($response->list),
            $response->message,
            $response->length,
            $response->parts
        );
    }

    /**
     * @param SendSmsToGroupBag $sendSmsToGroupBag
     * @return array
     * @throws SmsapiClientException
     */
    public function sendSmsToGroup(SendSmsToGroupBag $sendSmsToGroupBag): array
    {
        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($sendSmsToGroupBag)->list
        );
    }

    /**
     * @param SendSmsToGroupBag $sendSmsToGroupBag
     * @return array
     * @throws SmsapiClientException
     */
    public function sendFlashSmsToGroup(SendSmsToGroupBag $sendSmsToGroupBag): array
    {
        $sendSmsToGroupBag->flash = true;

        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($sendSmsToGroupBag)->list
        );
    }

    public function sendSmss(SendSmssBag $sendSmssBag): array
    {
        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($sendSmssBag)->list
        );
    }

    public function sendFlashSmss(SendSmssBag $sendSmssBag): array
    {
        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($sendSmssBag)->list
        );
    }

    /**
     * @param ScheduleSmsBag $scheduleSmsBag
     * @return Sms
     * @throws SmsapiClientException
     */
    public function scheduleSms(ScheduleSmsBag $scheduleSmsBag): Sms
    {
        $scheduleSmsBag->dateValidate = true;
        $scheduleSmsBag->details = true;

        $response = $this->makeRequest($scheduleSmsBag);

        return $this->dataFactoryProvider->provideSmsFactory()->createFromObjectWithDetails(
            current($response->list),
            $response->message,
            $response->length,
            $response->parts
        );
    }

    public function scheduleSmss(ScheduleSmssBag $scheduleSmssBag): array
    {
        $scheduleSmssBag->dateValidate = true;

        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($scheduleSmssBag)->list
        );
    }

    /**
     * @param ScheduleSmsBag $scheduleSmsBag
     * @return Sms
     * @throws SmsapiClientException
     */
    public function scheduleFlashSms(ScheduleSmsBag $scheduleSmsBag): Sms
    {
        $scheduleSmsBag->dateValidate = true;
        $scheduleSmsBag->flash = true;

        return $this->dataFactoryProvider
            ->provideSmsFactory()
            ->createFromObject(current($this->makeRequest($scheduleSmsBag)->list));
    }

    /**
     * @param ScheduleSmsToGroupBag $scheduleSmsToGroupBag
     * @return array
     * @throws SmsapiClientException
     */
    public function scheduleSmsToGroup(ScheduleSmsToGroupBag $scheduleSmsToGroupBag): array
    {
        $scheduleSmsToGroupBag->dateValidate = true;

        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($scheduleSmsToGroupBag)->list
        );
    }

    /**
     * @param ScheduleSmsToGroupBag $sendSmsToGroupBag
     * @return array
     * @throws SmsapiClientException
     */
    public function scheduleFlashSmsToGroup(ScheduleSmsToGroupBag $sendSmsToGroupBag): array
    {
        $sendSmsToGroupBag->dateValidate = true;
        $sendSmsToGroupBag->flash = true;

        return array_map(
            [$this->dataFactoryProvider->provideSmsFactory(), 'createFromObject'],
            $this->makeRequest($sendSmsToGroupBag)->list
        );
    }

    /**
     * @param DeleteScheduledSmssBag $deleteScheduledSmsBag
     * @throws SmsapiClientException
     */
    public function deleteScheduledSms(DeleteScheduledSmssBag $deleteScheduledSmsBag)
    {
        $deleteScheduledSmsBag->schDel = implode(',', $deleteScheduledSmsBag->smsIds);
        unset($deleteScheduledSmsBag->smsIds);
        $this->makeRequest($deleteScheduledSmsBag);
    }

    /**
     * @param $data
     * @return stdClass
     * @throws SmsapiClientException
     */
    private function makeRequest($data): stdClass
    {
        return $this->requestExecutorFactory
            ->createLegacyRequestExecutor($this->externalHttpClient)
            ->request('sms.do', (array)$data);
    }
}
