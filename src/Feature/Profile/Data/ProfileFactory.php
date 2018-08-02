<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

use stdClass;

/**
 * @internal
 */
class ProfileFactory
{
    public function createFromObject(stdClass $object): Profile
    {
        $profile = new Profile();
        $profile->name = $object->name;
        $profile->username = $object->username;
        $profile->email = $object->email;
        $profile->phoneNumber = $object->phone_number;
        $profile->paymentType = $object->payment_type;
        $profile->userType = $object->user_type;

        if (isset($object->points)) {
            $profile->points = $object->points;
        }

        return $profile;
    }
}
