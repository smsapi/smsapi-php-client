<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

use stdClass;

/**
 * @internal
 */
class MoneyFactory
{
    public function createFromObject(stdClass $object): Money
    {
        $money = new Money();

        $money->amount = $object->amount;
        $money->currency = $object->currency;

        return $money;
    }
}
