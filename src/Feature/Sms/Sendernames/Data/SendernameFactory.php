<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Sendernames\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class SendernameFactory
{
    public function createFromObject(stdClass $object): Sendername
    {
        $sendername = new Sendername();
        $sendername->status = $object->status;
        $sendername->createdAt = new DateTime($object->created_at);
        $sendername->isDefault = $object->is_default;
        $sendername->sender = $object->sender;

        return $sendername;
    }
}
