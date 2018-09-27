<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Sms\Bag\DeleteSmsBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Data\Sms;
use Smsapi\Client\Feature\Sms\Sendernames\SendernamesFeature;
use Smsapi\Client\Feature\Sms\Sendernames\SendernamesHttpFeature;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;
use stdClass;

/**
 * @internal
 */
class SmsHttpFeature implements SmsFeature
{
    /**
     * @var DataFactoryProvider
     */
    private $dataFactoryProvider;

    /**
     * @var LegacyRequestExecutor
     */
    private $legacyRequestExecutor;

    /**
     * @var RestRequestExecutor
     */
    private $restRequestExecutor;

    /**
     * @var LegacyRequestBuilderFactory
     */
    private $legacyRequestBuilderFactory;

    /**
     * @var RestRequestBuilderFactory
     */
    private $restRequestBuilderFactory;

    public function __construct(
        LegacyRequestExecutor $legacyRequestExecutor,
        RestRequestExecutor $restRequestExecutor,
        LegacyRequestBuilderFactory $legacyRequestBuilderFactory,
        RestRequestBuilderFactory $restRequestBuilderFactory,
        DataFactoryProvider $dataFactoryProvider
    ) {
        $this->legacyRequestExecutor = $legacyRequestExecutor;
        $this->restRequestExecutor = $restRequestExecutor;
        $this->legacyRequestBuilderFactory = $legacyRequestBuilderFactory;
        $this->restRequestBuilderFactory = $restRequestBuilderFactory;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function sendernameFeature(): SendernamesFeature
    {
        return new SendernamesHttpFeature(
            $this->restRequestExecutor,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider->provideSendernameFactory()
        );
    }

    public function sendSms(SendSmsBag $sendSmsBag): Sms
    {
        return $this->dataFactoryProvider
            ->provideSmsFactory()
            ->createFromObject(current($this->makeRequest($sendSmsBag)->list));
    }

    /**
     * @param SendSmsBag $sendSmsBag
     * @return Sms
     * @throws SmsapiClientException
     */
    public function sendFlashSms(SendSmsBag $sendSmsBag): Sms
    {
        $sendSmsBag->flash = true;

        return $this->dataFactoryProvider
            ->provideSmsFactory()
            ->createFromObject(current($this->makeRequest($sendSmsBag)->list));
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

    /**
     * @param ScheduleSmsBag $scheduleSmsBag
     * @return Sms
     * @throws SmsapiClientException
     */
    public function scheduleSms(ScheduleSmsBag $scheduleSmsBag): Sms
    {
        $scheduleSmsBag->dateValidate = true;

        return $this->dataFactoryProvider
            ->provideSmsFactory()
            ->createFromObject(current($this->makeRequest($scheduleSmsBag)->list));
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
     * @param DeleteSmsBag $deleteScheduledSmsBag
     * @throws SmsapiClientException
     */
    public function deleteScheduledSms(DeleteSmsBag $deleteScheduledSmsBag)
    {
        $deleteScheduledSmsBag->schDel = $deleteScheduledSmsBag->smsIds;
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
        $requestBuilder = $this->legacyRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withPath('sms.do')
            ->withBuiltInParameters((array) $data)
            ->get();

        return $this->legacyRequestExecutor->execute($request);
    }
}
