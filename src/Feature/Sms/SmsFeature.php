<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms;

use Smsapi\Client\Feature\Sms\Bag\DeleteScheduledSmssBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmssBag;
use Smsapi\Client\Feature\Sms\Bag\ScheduleSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmssBag;
use Smsapi\Client\Feature\Sms\Bag\SendSmsToGroupBag;
use Smsapi\Client\Feature\Sms\Data\Sms;
use Smsapi\Client\Feature\Sms\Sendernames\SendernamesFeature;

/**
 * @api
 */
interface SmsFeature
{
    public function sendernameFeature(): SendernamesFeature;

    public function sendSms(SendSmsBag $sendSmsBag): Sms;

    public function sendFlashSms(SendSmsBag $sendSmsBag): Sms;

    public function sendSmsToGroup(SendSmsToGroupBag $sendSmsToGroupBag): array;

    public function sendFlashSmsToGroup(SendSmsToGroupBag $sendSmsToGroupBag): array;

    public function sendSmss(SendSmssBag $sendSmssBag): array;

    public function sendFlashSmss(SendSmssBag $sendSmssBag): array;

    public function scheduleSms(ScheduleSmsBag $scheduleSmsBag): Sms;

    public function scheduleFlashSms(ScheduleSmsBag $scheduleSmsBag): Sms;

    public function scheduleSmsToGroup(ScheduleSmsToGroupBag $scheduleSmsToGroupBag): array;

    public function scheduleFlashSmsToGroup(ScheduleSmsToGroupBag $sendSmsToGroupBag): array;

    public function scheduleSmss(ScheduleSmssBag $scheduleSmssBag): array;

    public function deleteScheduledSms(DeleteScheduledSmssBag $deleteScheduledSmsBag);
}
