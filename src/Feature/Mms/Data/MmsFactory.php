<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Mms\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class MmsFactory
{
    public function createFromObject(stdClass $object): Mms
    {
        $mms = new Mms();
        $mms->id = $object->id;
        $mms->points = (float)$object->points;
        $mms->status = $object->status;
        $mms->dateSent = new DateTime('@' . $object->date_sent);
        $mms->number = $object->number;

        return $mms;
    }
}
