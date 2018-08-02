<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

use stdClass;

/**
 * @internal
 */
class ProfilePriceCountryFactory
{

    public function createFromObject(stdClass $object): ProfilePriceCountry
    {
        $profilePriceCountry = new ProfilePriceCountry();

        $profilePriceCountry->name = $object->name;
        $profilePriceCountry->mcc = $object->mcc;

        return $profilePriceCountry;
    }
}
