<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

use stdClass;

/**
 * @internal
 */
class ProfilePriceNetworkFactory
{

    public function createFromObject(stdClass $object): ProfilePriceNetwork
    {
        $profilePriceNetwork = new ProfilePriceNetwork();

        $profilePriceNetwork->name = $object->name;
        $profilePriceNetwork->mnc = $object->mnc;

        return $profilePriceNetwork;
    }
}
