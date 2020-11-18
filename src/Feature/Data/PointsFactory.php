<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Data;

use stdClass;

/**
 * @internal
 */
class PointsFactory
{
    public function createFromObject(stdClass $object): Points
    {
        $points = new Points();
        $points->fromAccount = $object->from_account;
        $points->perMonth = $object->per_month;

        return $points;
    }
}
