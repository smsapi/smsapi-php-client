<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile;

use Smsapi\Client\Feature\Profile\Data\Profile;

/**
 * @api
 */
interface ProfileFeature
{

    public function findProfile(): Profile;
}
