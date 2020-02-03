<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Mfa\Data;

use stdClass;

/**
 * @internal
 */
class MfaFactory
{
    public function createFromObject(stdClass $object): Mfa
    {
        $mfa = new Mfa();
        $mfa->id = $object->id;
        $mfa->code = $object->code;
        $mfa->phoneNumber = $object->phone_number;
        $mfa->from = $object->from;

        return $mfa;
    }
}
