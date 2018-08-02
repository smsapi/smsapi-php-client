<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile;

/**
 * @api
 */
interface SmsapiPlProfileFeature extends ProfileFeature
{

    public function findProfilePrices(): array;
}
