<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Vms\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class VmsFactory
{
    public function createFromObject(stdClass $object): Vms
    {
        $vms = new Vms();
        $vms->id = $object->id;
        $vms->points = (float)$object->points;
        $vms->status = $object->status;
        $vms->dateSent = new DateTime('@' . $object->date_sent);
        $vms->number = $object->number;

        return $vms;
    }
}
